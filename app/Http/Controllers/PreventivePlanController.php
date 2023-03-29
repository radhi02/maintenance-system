<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\task;
use App\Models\Equipment;
use App\Models\Planmaster;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;

class PreventivePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::select("first_name", "last_name","id")->get();
        $planmasters = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.maintenance_type', '=', 'Preventive')
        ->where('planmasters.created_by', '=', $user->id)
        ->get(['E.equipment_name','users.first_name','users.last_name','planmasters.uniqueid','planmasters.frequancy','planmasters.id','planmasters.frequancy','planmasters.maintenance_type','planmasters.start_date','planmasters.ticket_status'])
        ->unique('uniqueid');
        return view('preventive.index',compact('planmasters','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $equipement = Equipment::select("equipment_name", "id")->where('company_id',$user->company_id)->get();
        $users = User::select("first_name", "last_name","id")->where('Role',3)->where('department_id',$user->department_id)->get(); 
        return view('preventive.create',compact('equipement','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $radioPrimary = $request->radioPrimary;
        $datelist = $request->datelist;
        $equipment_id =  $request->equipment_id;
        $user = Auth::user();
        $planRecords = [];
        $uniqueid = $this->unique_code(15);
        $endUserId = Equipment::where('id', $equipment_id)->pluck('user_id')->first();

        foreach($radioPrimary as $k1 => $v1) {
            // 'uniqueid' => $equipment_id.'_'.$request->frequancy.'_'.str_replace('-', '_', date("Y-m-d")),
            $planRecords[] = [
                'uniqueid' => $uniqueid,
                'equipment_id' => $equipment_id,
                'frequancy' => $request->frequancy,
                'start_date' => date('Y-m-d', strtotime($request->date)),
                'assigned_to_userid' => $request->assigned_to_userid,
                'tasktype' => $v1,
                'maintenance_type' => 'Preventive',
                'ticket_status' => 'pending',
                'created_by' => $user->id,
                'enduser_id' => $endUserId,
                'plan_date' =>  date('Y-m-d', strtotime($datelist[$k1]))
            ];
        }
        DB::table("planmasters")->insert($planRecords);
        return redirect()->route('plan.index')->with('success','Plan created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scheduledata = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->where('planmasters.uniqueid',$id)
        ->get(['E.equipment_name','E.major','E.minor','users.first_name','users.last_name','planmasters.start_date','planmasters.*']);

        return view('preventive.show',compact('scheduledata'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {                
        $user = Auth::user();
        $equipement = Equipment::select("equipment_name", "id")->where('company_id',$user->company_id)->get();
        $users = User::select("first_name", "last_name","id")->where('Role',3)->get();
        $MaintenancePlan = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.uniqueid',$id)
        ->get(['planmasters.*','E.equipment_name'])->unique('uniqueid')->first();

        $scheduledata = Planmaster::select('id','uniqueid','plan_date','tasktype')->where('uniqueid',$id)->get();
        return view('preventive.create',compact('equipement','users','MaintenancePlan','scheduledata'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        Planmaster::where('uniqueid',$id)->delete();
        
        $radioPrimary = $request->radioPrimary;
        $datelist = $request->datelist;
        $equipment_id =  $request->equipment_id;
        $user = Auth::user();
        $planRecords = [];
        $uniqueid = $this->unique_code(15);
        $endUserId = Equipment::where('id', $equipment_id)->pluck('user_id')->first();

        foreach($radioPrimary as $k1 => $v1) {
            $planRecords[] = [
                'uniqueid' => $uniqueid,
                'equipment_id' => $equipment_id,
                'frequancy' => $request->frequancy,
                'start_date' => date('Y-m-d', strtotime($request->date)),
                'assigned_to_userid' => $request->assigned_to_userid,
                'tasktype' => $v1,
                'maintenance_type' => 'Preventive',
                'ticket_status' => 'pending',
                'created_by' => $user->id,
                'enduser_id' => $endUserId,
                'plan_date' =>  date('Y-m-d', strtotime($datelist[$k1]))
            ];
        }
        DB::table("planmasters")->insert($planRecords);
        return redirect()->route('home')->with('success','Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function destroy($id)
    {
        Planmaster::where('uniqueid', $id)->delete();
        return redirect()->route('plan.index')->with('success','Plan deleted successfully');
    }
    
    public function showMaintenanceEnginner(Request $request)
    {
        $equipement = Equipment::select("department_id")->where('id',$request->eId)->get()->first();
        $data['users'] = User::select("first_name", "last_name","id")->where('department_id',$equipement->department_id)->where('Role',3)->get();
        return response()->json($data);
    }
    
    public function unique_code($limit = 15)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

}
