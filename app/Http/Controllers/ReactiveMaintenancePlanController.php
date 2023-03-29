<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Department;
use App\Models\ReactiveMaintenance;
use App\Models\Planmaster;
use Illuminate\Http\Request;
use App\Models\ReactiveMaintenancePlan;
use App\Models\Engactivity;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\StatusMail;
use Mail;
class ReactiveMaintenancePlanController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ReactiveMaintenancePlan-index|ReactiveMaintenancePlan-create|ReactiveMaintenancePlan-edit|ReactiveMaintenancePlan-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:ReactiveMaintenancePlan-create', ['only' => ['create','store']]);
         $this->middleware('permission:ReactiveMaintenancePlan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ReactiveMaintenancePlan-destroy', ['only' => ['destroy']]);
    }   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('ReactiveMaintenancePlan-index')) {
        $id = Auth::user()->id;
        if(Auth::user()->Role != 2  ){
        $reactive_maintenance = DB::table('planmasters')
        ->select('planmasters.*','equipment.equipment_name as ename','users.first_name as uname' )
        ->join('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
        ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->where('planmasters.maintenance_type','=','Reactive')
        ->get();
        }else{
            $reactive_maintenance = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name as ename','users.first_name as uname'  )
            ->join('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->where('planmasters.assigned_to_userid','=',$id)
            ->where('planmasters.maintenance_type','=','Reactive')
            ->get();

        }
        //  dd($reactive_maintenance);
        $users = User::select("first_name", "last_name","id")->get();

        $log = Auth::user()->id;
        $log2 = Auth::user()->first_name;
        // dd($log);
        return view('reactive_maintenance_plan.index',compact('users','reactive_maintenance','log','log2'));
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
    public function create(Request $request)
    {
        if(auth()->user()->can('ReactiveMaintenancePlan-create')) {
            $reactive_maintenance = DB::table('reactive_maintenances')
            ->select('reactive_maintenances.*','equipment.equipment_name as ename' )
            ->join('equipment', 'equipment.id', '=', 'reactive_maintenances.equipment_id')
            ->get();
            $users = User::select("first_name", "last_name","id")->get();
            $reactive_maintenances_id = $request->id;
            return view('reactive_maintenance_plan.create',compact('users','reactive_maintenance','reactive_maintenances_id'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->can('ReactiveMaintenancePlan-show')) {
            $ReactiveMaintenancePlan = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name as ename','users.first_name as uname' )
            ->join('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->where('planmasters.id','=',$id)
            ->get()->first();        
            return view('reactive_maintenance_plan.show',compact('ReactiveMaintenancePlan'));
        } else {
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    public function showdetail($id)
    {
            $ReactiveMaintenancePlan = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name as ename','users.first_name as uname','endusers.first_name as endname' )
            ->join('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->join('users as endusers', 'endusers.id', '=', 'planmasters.created_by')
            ->where('planmasters.id','=',$id)
            ->get()->first();
            $plandata = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.id',$id)
            ->first(['E.id as EId','E.equipment_name as Ename','E.major','E.minor','planmasters.*']);

            $plancost = DB::table("plancost")->leftjoin('planmasters as P', 'P.id', '=', 'plancost.plan_id')
            ->where('P.id',$id)
            ->get(['plancost.*']);
            return view('reactive_maintenance_plan.show_detail',compact('ReactiveMaintenancePlan','plandata','plancost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('ReactiveMaintenancePlan-edit')) {

            $reactive_maintenance = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.id',$id)
            ->first(['E.id as EId','E.equipment_name as Ename','E.major','E.minor','planmasters.*']);

            $plancost = DB::table("plancost")->leftjoin('planmasters as P', 'P.id', '=', 'plancost.plan_id')
            ->where('P.id',$id)
            ->get(['plancost.*']);

            $users = User::select("first_name", "last_name","id")->get();
            $reactive_maintenances_id = $id;
            return view('reactive_maintenance_plan.create',compact('plancost','users','reactive_maintenance','reactive_maintenances_id'));
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
    public function update(Request $request,$id)
    {
        // dd($request->all());
        if(auth()->user()->can('ReactiveMaintenancePlan-update')) {           
            $txtdetail = ($request->txtdetail)?$request->txtdetail:[];
            $txttype = ($request->txttype)?$request->txttype:[];
            $txtsparecost = ($request->txtsparecost)?$request->txtsparecost:[];
            $txtspareremark = ($request->txtspareremark)?$request->txtspareremark:[];
            $Records = NULL;
            foreach($txtdetail as $k=>$v){
                $Records[] = [
                    'plan_id'=>$id,
                    'detail'=>$txtdetail[$k],
                    'type'=>$txttype[$k],
                    'cost'=>$txtsparecost[$k],
                    'remark'=>$txtspareremark[$k]
                ];
            }
            // dd($Records);
            if($Records != NULL) {
                DB::table("plancost")->insert($Records);
            }
            
            //Get Planmaster record
            $pData = Planmaster::where('id', $id)->firstOrFail();
            $note = json_decode($pData->remark_by_enginner)??[];
            
            //Update action json
              if($request->note != NULL) {
                $note[] = [
                    'note'=>$request->note,
                    'date'=>date('Y-m-d H:i:s')
                ];    
            }

            $log = Auth::user()->id;

            $query = Engactivity::where('plan_id',$id)->whereNull('actual_end_date')->select('id','actual_start_date')->firstOrFail();
            $time1 = date('Y-m-d H:i:s');
            $time2 = $query['actual_start_date'];
            $hourdiff = round((strtotime($time1) - strtotime($time2))/3600, 1);

            $oldPData = Planmaster::where('id', $id)->firstOrFail();
            $totalLossHrs = $oldPData->loss_hrs + $hourdiff;
            Engactivity::where('id',$query['id'])->update( ['actual_end_date' => date('Y-m-d H:i:s'),'loss_hrs' => $hourdiff]);


            $updateData = [
                'actual_end_date' => date("Y-m-d H:i:s"),
                'loss_hrs' => $totalLossHrs,
                'service_cost_external_vendor' =>$request->service_cost_external_vendor,
                'enduser_id' =>$request->$log,
                'ticket_status' => "complete",
            ];
            if(!empty($note)) {
                $updateData['remark_by_enginner'] = json_encode($note);
            }
            $create  = Planmaster::where('id',$id)->update($updateData);

            session()->flash('success', 'Reactive Maintenance Plan   Updated Successfuly.');
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
    public function destroy(ReactiveMaintenance $ReactiveMaintenance)
    {
        if(auth()->user()->can('ReactiveMaintenancePlan-destroy')) {

        $ReactiveMaintenance->delete();
        return redirect()->route('reactive_maintenance.index')->with('success','Reactive Maintenance  deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    function get_date(Request $request)
    {
        if(isset($request->equipment_id))
        {
            $equi = $request->equipment_id;
            $data = DB::table('reactive_maintenances')->where('equipment_id', '=', $equi)->where('deleted_at', '=', NULL)->get();
            $response = array();
            if(!$data->isEmpty())
            {
                foreach($data as $row)
                {
                    $response[] = array("value"=>$row->id,"date"=>$row->date,"Problem"=>$row->Problem,"status"=>$row->status);
                }
            }else{
                $response[] = array("value"=>"","date"=>'No record found');
            }
            echo json_encode($response);
            exit;
        }
    }
    public function changeEndstatus(Request $request){
        $status=$request->status;
        $remark=$request->remark;
        $idd=$request->idd;
        $log = Auth::user()->id;

        $pData = Planmaster::where('id', $idd)->firstOrFail();
        $remark = json_decode($pData->remark_by_manager)??[];
        //Update action json
        if($request->remark != NULL) {
            $remark[] = [
                'note'=>$request->remark,
                'date'=>date('Y-m-d H:i:s')
            ];
        }

        $ReactiveMaintenance = Planmaster::find($idd);
        $ReactiveMaintenance->enduser_id=$log;
        if(!empty($remark)) {
            $ReactiveMaintenance->remark_by_manager =json_encode($remark);
        }

        if($status == 'Rejected'){
            $ReactiveMaintenance->ticket_status = 'open';
            $ReactiveMaintenance->save();
            
            $create = Engactivity::create([
                'plan_id'=> $idd,
                'actual_start_date'=> date('Y-m-d H:i:s')
            ]);

        } else{
            $ReactiveMaintenance->ticket_status = 'close';
        }

        $ReactiveMaintenance->save();

        $equipdata = Equipment::select("department_id", "id")->where('id',$ReactiveMaintenance->equipment_id)->first();
        $deptId = $equipdata->department_id;
        $user_list = [];
        $hodid = User::where('department_id',$deptId)->where('Role',1)->get("id")->first();
        $user_list['hodid'] = $hodid->hod_id;
        $user_list['created_by'] = $ReactiveMaintenance->created_by;
        $user_list['enduser_id'] = $ReactiveMaintenance->enduser_id;
        $user_list['assigned_to_userid'] = $ReactiveMaintenance->assigned_to_userid;
        $user_list['actual_done_by'] = $ReactiveMaintenance->actual_done_by;
        $user_list = array_unique($user_list);
        $user_arry = User::select("email")->whereIn('id',$user_list)->get();
        $user_mail = [];
        $ename = $request->ename;
        $details = [
            'flag' => $status,
            'equpment' => $ename,
            'eqp' => 'This is for testing email reactive maintenance'
        ];
        foreach($user_arry as $user){
            $user_mail[] = $user->email;
        }
        // \Mail::to($user_mail)->send(new \App\Mail\StatusMail($details));
        return response()->json(['msg'=>1]);

    }


    public function changeUser(Request $request){

        $ReactiveMaintenance = ReactiveMaintenancePlan::find($request->id);
        $ReactiveMaintenance->user_id = $request->user_id;
        // dd($ReactiveMaintenance);
        $ReactiveMaintenance->save();
  
        return response()->json(['success'=>'Assign User change successfully.']);
    }
    public function changeUserself(Request $request){
        $ReactiveMaintenance = ReactiveMaintenancePlan::find($request->id);
        $ReactiveMaintenance->user_id = $request->selfuser_id;
        // dd($ReactiveMaintenance);
        $ReactiveMaintenance->save();
  
        return response()->json(['success'=>'Self Assign change successfully.']);
    }

    
}