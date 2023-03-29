<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\task;
use App\Models\Equipment;
use App\Models\Planmaster;
use App\Models\Plancost;
use App\Models\Department;
use App\Models\Engactivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use DB;
use Auth;
use SebastianBergmann\Environment\Console;

class PreventivePlanActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Planmaster-index|Planmaster-create|Planmaster-edit|Planmaster-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:Planmaster-create', ['only' => ['create','store']]);
         $this->middleware('permission:Planmaster-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Planmaster-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('Planmaster-index')) {
            $user = Auth::user();
            $planlist = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.maintenance_type', '=', 'Preventive')
            ->get(['E.equipment_name','E.major','E.minor','users.first_name','users.last_name','planmasters.*']);
            return view('preventive_activity.index',compact('planlist'));
        } else {
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('Planmaster-edit')) {
            $plandata = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.id',$id)
            ->first(['E.id as EId','E.equipment_name as Ename','E.major','E.minor','planmasters.*']);

            $plancost = DB::table("plancost")->leftjoin('planmasters as P', 'P.id', '=', 'plancost.plan_id')
            ->where('P.id',$id)
            ->get(['plancost.*']);
            return view('preventive_activity.create',compact('plandata','plancost'));
        } else {
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        if(auth()->user()->can('Planmaster-update')) {

            $user = Auth::user();

            // Spare/Labour Data
            $txtdetail = ($request->txtdetail)?$request->txtdetail:[];
            $txttype = ($request->txttype)?$request->txttype:[];
            $txtsparecost = ($request->txtsparecost)?$request->txtsparecost:[];
            $txtspareremark = ($request->txtspareremark)?$request->txtspareremark:[];
            $Records = NULL;
            foreach($txtdetail as $k=>$v) {
                if($txtdetail[$k] != null) {
                    $Records[] = [
                        'plan_id'=>$id,
                        'detail'=>$txtdetail[$k],
                        'type'=>$txttype[$k],
                        'cost'=>$txtsparecost[$k],
                        'remark'=>$txtspareremark[$k]
                    ];
                }
            }
            if($Records != NULL) {
                DB::table("plancost")->insert($Records);
            }

            //Get Planmaster record
            $oldPData = Planmaster::where('id', $id)->firstOrFail();
            $note = json_decode($oldPData->remark_by_enginner)??[];
            $tJson = json_decode($oldPData->task_json)??[];

            // Activity Checklist data
            $chkactivity = ($request->chkactivity)?$request->chkactivity:[];
            $txtactivitydetail = ($request->txtactivitydetail)?$request->txtactivitydetail:[];
            $txtactivityremark = ($request->txtactivityremark)?$request->txtactivityremark:[];
            $ActRecords = [];
            foreach($chkactivity as $k=>$v){
                $ActRecords[] = [
                    'activity'=>$v,
                    'detail'=>$txtactivitydetail[$k],
                    'remark'=>$txtactivityremark[$k],
                    'date'=>date('Y-m-d H:i:s')
                ];
            }
            //Update action json
            if($request->note != NULL) {
                $note[] = [
                    'note'=>$request->note,
                    'date'=>date('Y-m-d H:i:s')
                ];
            }
            // Update Activity Json 
            $ActRecords = array_merge($tJson,$ActRecords);

            // Update Activity Checklist
            $chkactivity = [];
            if($request->chkactivity != '') {
                $chkactivity = $request->chkactivity;
            }
            $tList = [];
            if($oldPData->done_task_list != NULL) {
                $tList = explode(",",$oldPData->done_task_list);
            }
            $tList = array_merge($tList,$chkactivity);

            $updateData = [
                'service_cost_external_vendor' => isset($request->cost_servies)?$request->cost_servies:NULL,
                'actual_done_by' => $user->id,
                'done_task_list' => ($tList != NULL)?implode(',',($tList)):NULL,
                "task_json" => json_encode($ActRecords)
            ];
            if(!empty($note)) {
                $updateData['remark_by_enginner'] = json_encode($note);
            }
            Planmaster::where('id',$id)->update($updateData);
            
            if (isset($request->finishActivity)) {
                $query = Engactivity::where('plan_id',$id)->whereNull('actual_end_date')->select('id','actual_start_date')->firstOrFail();
                $time1 = date('Y-m-d H:i:s');
                $time2 = $query['actual_start_date'];
                
                $hourdiff = round((strtotime($time1) - strtotime($time2))/3600, 1);
                $totalLossHrs = $oldPData->loss_hrs + $hourdiff;
                Engactivity::where('id',$query['id'])->update( ['actual_end_date' => date('Y-m-d H:i:s'),'loss_hrs' => $hourdiff]);
                Planmaster::where('id',$id)->update([
                    'actual_start_date' => null,
                    'ticket_status' => "complete",
                    'actual_end_date' => null,
                    'loss_hrs' => $totalLossHrs
                ]);
            }

            session()->flash('success', 'Plan Completed Successfuly.');
            return redirect()->route('home');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateByEndUser($id)
    {
        $plandata = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->join('users as u2', 'u2.id', '=', 'planmasters.actual_done_by')
        ->where('planmasters.id',$id)        
        ->first(['E.id as EId',DB::raw("CONCAT(users.first_name,' ',users.last_name) as assigned_user"),DB::raw("CONCAT(u2.first_name,' ',u2.last_name) as worked_by"),'E.equipment_name as Ename','E.major','E.minor','planmasters.*']);
        return view('preventive_activity.enduser_activity',compact('plandata'));
    }

    public function statusByEndUser(Request $request,$id)
    {
        $user = Auth::user();

        $oldPData = Planmaster::where('id', $id)->firstOrFail();
        $note = json_decode($oldPData->remark_by_manager)??[];
        //Update action json
        if($request->remark != NULL) {
            $note[] = [
                'note'=>$request->remark,
                'date'=>date('Y-m-d H:i:s')
            ];
        }

        $updateData['enduser_id'] = $user->id;

        if(!empty($note)) {
            $updateData['remark_by_manager'] = json_encode($note);    
        }

        if ($request->btnstatus == "Rejected") {
            $updateData['ticket_status'] = "open";
        } else if ($request->btnstatus == "Approved") {
            $updateData['ticket_status'] = "close";
        }
        Planmaster::where('id',$id)->update($updateData);

        $details = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.id', '=', $id)
        ->get(['E.equipment_name','E.minor','E.major',DB::raw("CONCAT(users.first_name,' ',users.last_name) as assigned_user"),'planmasters.frequancy','planmasters.*']);

        $equipdata = Equipment::select("department_id", "id")->where('id',$oldPData->equipment_id)->first();
        $deptId = $equipdata->department_id;
        $user_list = [];
        $hodid = User::where('department_id',$deptId)->where('Role',1)->get("id")->first();
        $user_list['hodid'] = $hodid->hod_id;
        $user_list['created_by'] = $oldPData->created_by;
        $user_list['enduser_id'] = $oldPData->enduser_id;
        $user_list['assigned_to_userid'] = $oldPData->assigned_to_userid;
        $user_list['actual_done_by'] = $oldPData->actual_done_by;
        $user_list = array_unique($user_list);
        $user_arry = User::select("email")->whereIn('id',$user_list)->get();
        $user_mail = [];
        foreach($user_arry as $user){
            $user_mail[] = $user->email;
        }
        $filename = 'enduserstatus';
        // \Mail::to($user_mail)->send(new \App\Mail\PreventiveMail($details,$filename));

        session()->flash('success', 'You have '.$request->btnstatus. ' Plan');
        return redirect()->route('home');
    }

    public function startPMActivity($id){
        Planmaster::where('id',$id)->update(['actual_start_date' => date('Y-m-d H:i:s')]);
        $create = Engactivity::create([
            'plan_id'=> $id,
            'actual_start_date'=> date('Y-m-d H:i:s')
        ]);
        session()->flash('success', 'Activity Started.');
        return back();
    }
    
    public function addNoteData(Request $request){
        Planmaster::where('id',$request->plan_id)->update(['worknote' => $request->note]);
        return response()->json(['msg'=>1]);
    }
    
    public function getNoteData(Request $request){
        $pNote = Planmaster::where('id',$request->plan_id)->select('worknote')->firstOrFail();
        return response()->json($pNote);
    }
    public function deleteplancost(Request $request){
        $id = $request->id;
        $plan_id = $request->plan_id;
        DB::table('plancost')->where('id',$id)->delete();
        $cost = DB::table('plancost')->where('plan_id',$plan_id)->sum('cost');
        return response()->json(['cost'=>$cost]);    
    }    
}
