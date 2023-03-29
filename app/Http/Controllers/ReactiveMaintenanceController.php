<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Planmaster;
use App\Models\ReactiveMaintenance;
use App\Models\Engactivity;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
class ReactiveMaintenanceController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ReactiveMaintenance-index|ReactiveMaintenance-create|ReactiveMaintenance-edit|ReactiveMaintenance-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:ReactiveMaintenance-create', ['only' => ['create','store']]);
         $this->middleware('permission:ReactiveMaintenance-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ReactiveMaintenance-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('ReactiveMaintenance-index')) {
        $users = User::select("first_name", "last_name","id")->get();
        $log = Auth::user()->id;
        $log2 = Auth::user()->first_name;
        $ReactiveMaintenance = DB::table('planmasters')
        ->select('planmasters.*','equipment.equipment_name as ename','users.first_name as uname' )
        ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
        ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->where('planmasters.maintenance_type','=','Reactive')
        ->where('planmasters.created_by','=',$log)
        ->get();

        return view('reactive_maintenance.index',compact('ReactiveMaintenance','users','log','log2'));
    }else{
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
        if(auth()->user()->can('ReactiveMaintenance-create')) {
        $equipment = Equipment::select("equipment_name", "id")->where('equipment_status', '=', 'Active')->get();
        $users = User::select("first_name", "last_name","id")->get();

        return view('reactive_maintenance.create',compact('equipment','users'));
       }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $log = Auth::user()->id;
        if(auth()->user()->can('ReactiveMaintenance-store')) {
            $create = Planmaster::create([
                'equipment_id'=>$request->equipment_id,
                'Problem'=>$request->Problem,
                'maintenance_type'=>$request->maintenance_type,
                'plan_date'=>$request->plan_date,
                'ticket_date'=>date('Y-m-d H:i:s'),
                'criticality'=>$request->criticality,
                'actual_start_date' => date('Y-m-d H:i:s'),
                'created_by'=>$log,
                'enduser_id'=>$log,
                'ticket_status'=>'open'
            ]);

            $create = Engactivity::create([
                'plan_id'=> $create->id,
                'actual_start_date'=> date('Y-m-d H:i:s')
            ]);
    
        return redirect()->route('reactive_maintenance.index')->with('success','Reactive Maintenance created successfully.');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }   
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
        if(auth()->user()->can('ReactiveMaintenance-edit')) {
            $ReactiveMaintenance = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.id',$id)
            ->first(['E.id as EId','E.equipment_name as Ename','E.major','E.minor','planmasters.*']);

        $users = User::select("first_name", "last_name","id")->get();
        $equipment = Equipment::select("equipment_name", "id")->where('equipment_status', '=', 'Active')->get();
        return view('reactive_maintenance.create',compact('ReactiveMaintenance','equipment','users'));
    }else{
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
        if(auth()->user()->can('ReactiveMaintenance-update')) {
         
            $log = Auth::user()->id;
            $create = Planmaster::where('id',$id)->update([
                'equipment_id'=>$request->equipment_id,
                'Problem'=>$request->Problem,
                'maintenance_type'=>$request->maintenance_type,
                'plan_date'=>$request->plan_date,
                'ticket_date'=>date('Y-m-d H:i:s'),
                'criticality'=>$request->criticality,
                'created_by'=>$log,
                'enduser_id'=>$log,
                'ticket_status'=>'open'
            ]);
            session()->flash('success', 'Reactive Maintenance   Updated Successfuly.');
            return redirect()->route('reactive_maintenance.index');
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
    public function destroy(Request $request,$id)
    {
        if(auth()->user()->can('ReactiveMaintenance-destroy')) {
            $Planmaster = Planmaster::find($id)->delete();
            return redirect()->route('reactive_maintenance.index')->with('success','Reactive Maintenance  deleted successfully');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }
    public function newdestroy(Request $request)
    {
        $Planmaster = Planmaster::find($request->id)->delete();
        return response()->json(['success'=>'Reactive Maintenance deleted successfully.']);  
    }
    public function changeUserselfTicket (Request $request){
        $ReactiveMaintenance = Planmaster::find($request->id);
        $ReactiveMaintenance->assigned_to_userid = $request->selfuser_id;
        // dd($ReactiveMaintenance);
        $ReactiveMaintenance->save();
  
        return response()->json(['success'=>'Self Assign change successfully.']);
    }
    
    public function changeUserTicket(Request $request){

       $ReactiveMaintenance = Planmaster::whereIn('id', $request->id)->update(['assigned_to_userid' => $request->user_id]);
       return response()->json(['msg'=>1]);
       
    }
    
}
