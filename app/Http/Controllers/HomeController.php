<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\task;
use App\Models\Equipment;
use App\Models\Planmaster;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Engactivity;
use DB;
use Auth;
use Mail;
use App\Mail\PreventiveMail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \DB::enableQueryLog();

        $logUser = Auth::user()->id;
        $logUserRole = Auth::user()->Role;

        // Calendar record
        if(request()->ajax()){
            $events = Planmaster::leftJoin('equipment as E', 'E.id', '=', 'planmasters.equipment_id');
            // Enginner
            if($logUserRole == 3) {
                $events->where('planmasters.assigned_to_userid','=',$logUser);
            }
            // Enduser
            if($logUserRole == 2) {
                $events->where('planmasters.enduser_id','=',$logUser);    
            }
            $events = $events->get(['planmasters.id','E.equipment_name as title','planmasters.ticket_status','planmasters.plan_date as start']);
            $tmp101 = [];
            foreach($events as $eq){
                $tmp101[$eq['id']] = [
                    'id' => $eq['id'],
                    'title' => $eq['title'],
                    'ticket_status' => $eq['ticket_status'],
                    'start' => $eq['start'],
                ];
                if($eq['ticket_status'] == "pending") $tmp101[$eq['id']]['color'] = '#fd7e14'; // Orange
                if($eq['ticket_status'] == "open") $tmp101[$eq['id']]['color'] = '#6610f2'; // Dark Blue
                if($eq['ticket_status'] == "complete") $tmp101[$eq['id']]['color'] = '#3498dbe3'; // Sky Blue 
                if($eq['ticket_status'] == "close") $tmp101[$eq['id']]['color'] = '#28a745'; // Green 
            }
            
            $query = Engactivity::select('id','plan_id','actual_start_date','actual_end_date')->get();
            foreach($query as $k1 => $v1){
                if($k1 == 0) $tmp101[$v1['plan_id']]['start'] = $v1['actual_start_date'];
                if($v1['actual_end_date'] != null) {
                    $tmp101[$v1['plan_id']]['end'] = $v1['actual_end_date'];
                }
            }
            $tmp102 = [];
            foreach($tmp101 as $t) {
                $tmp102[] = $t;
            }
            $collection1 = new Collection($tmp102);
            if(count($tmp102) > 0) {
                return response()->json($collection1);
            } else return response()->json();
        }
        return view('home');
    }
    public function fetchdashboarddata()
    {
        \DB::enableQueryLog();

        $logUser = Auth::user()->id;
        $logUserRole = Auth::user()->Role;
        $users = User::select("first_name", "last_name","id")->get();
        $usersAssign = User::select("first_name", "last_name","id")->where('Role','3')->get();
        $openTicketEng = $TodayEngPMPlan = $reactiveUnassignTicket = $eng_close = $reactive_rejected = $CompletedPreventivePlan = $pmplanlist = $openTicketEnduser = $allOpenTicket = $allCloseTicket = $addNotetoTicket = [];
        $myopencount = $myclosecount = $myunassign = 0;
        // To-do List
        if($logUserRole == 3) {
            // Open ticket for current Eng.
            $tmpOTE = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','equipment.minor','equipment.major','endusers.first_name as endname')
            ->join('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->join('users as endusers', 'endusers.id', '=', 'planmasters.created_by')
            ->where('planmasters.assigned_to_userid','=',$logUser)
            ->where('planmasters.maintenance_type', '=', 'Reactive')
            ->where('planmasters.ticket_status', 'open');
            $openTicketEng = $tmpOTE->get();

            // Today PM Plan for current Eng.
            $tmpTEPM = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
            ->where('planmasters.ticket_status', 'open')
            ->where('planmasters.assigned_to_userid', '=', $logUser)
            ->where('planmasters.maintenance_type', '=', 'Preventive')
            ->where('planmasters.plan_date', '<=', Carbon::today());
            $TodayEngPMPlan = $tmpTEPM->get(['endusers.first_name as endname','E.equipment_name','E.major','E.minor','planmasters.*']);
            $myopencount = $tmpTEPM->count() + $tmpOTE->count();

            // Reactive Maintenance Plan UnAssigned Activity 
            $tmpRUT = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','users.first_name as uname','endusers.first_name as endname' )
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.created_by')
            ->where('planmasters.maintenance_type','=','Reactive')
            ->where('planmasters.created_by','=',$logUser)
            ->orWhereNull('planmasters.assigned_to_userid');
            $reactiveUnassignTicket = $tmpRUT->get();
            $myunassign = $tmpRUT->count();

            // Current eng. completed ticket
            $tmpEC = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','users.first_name as uname','equipment.minor','equipment.major','endusers.first_name as endname' )
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
            ->where('planmasters.ticket_status','=','close')
            ->where('planmasters.assigned_to_userid','=',$logUser);
            $eng_close = $tmpEC->get();
            $myclosecount = $tmpEC->count();
            
            $addNotetoTicket = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.assigned_to_userid','=',$logUser)
            ->where('planmasters.ticket_status', '=', 'open')
            ->whereBetween('planmasters.plan_date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->get(['E.equipment_name','E.major','E.minor','planmasters.*']);

        } else if($logUserRole == 2) {
            // Enduser will check 
            $tmpOTE = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','equipment.minor','equipment.major','users.first_name as uname')
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->where('planmasters.created_by','=',$logUser)
            ->where('planmasters.maintenance_type', '=', 'Reactive')
            ->where('planmasters.ticket_status','=','complete');
            $openTicketEnduser = $tmpOTE->get();

            /**
             * Completed Preventive Plan.
             */
            $tmpCPP = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.ticket_status','=','complete')
            ->where('planmasters.maintenance_type', '=', 'Preventive')
            ->where('planmasters.enduser_id','=',$logUser);
            $CompletedPreventivePlan = $tmpCPP->get(['E.equipment_name','users.first_name as uname','users.last_name','planmasters.*','E.minor','E.major']);

            $myopencount = $tmpCPP->count() + $tmpOTE->count();

            // Current end user completed ticket
            $tmpEC = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','users.first_name as uname','equipment.minor','equipment.major')
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->where('planmasters.ticket_status','=','close')
            ->where('planmasters.enduser_id','=',$logUser);
            $eng_close = $tmpEC->get();
            $myclosecount = $tmpEC->count();

            // Reactive Maintenance Plan UnAssigned Activity 
            $tmpRUT = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','endusers.first_name as endname')
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.created_by')
            ->where('planmasters.maintenance_type','=','Reactive')
            ->where('planmasters.ticket_status','=','open')
            ->where('planmasters.created_by','=',$logUser)
            ->whereNull('assigned_to_userid');
            $reactiveUnassignTicket = $tmpRUT->get();
            $myunassign = $tmpRUT->count();

        } else if($logUserRole == 1) {
            \DB::enableQueryLog();
            
            // Maintenance Head will approve/reject PM plan
            $tmp = Planmaster::leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
            ->leftjoin('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.ticket_status', '=', 'pending')
            ->where('planmasters.maintenance_type', '=', 'Preventive')
            ->where('E.department_id', '=', Auth::user()->department_id)
            ->get(['endusers.first_name as endname','E.equipment_name','users.first_name','users.last_name','planmasters.*']);
            $tmpid= 0; 
            foreach($tmp as $plan) {
                $pmplanlist[$plan['uniqueid']] = $plan;
            }
            // dd(\DB::getQueryLog()); // Show results of log

            // Reactive Maintenance Plan UnAssigned Activity 
            $tmpRUT = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','endusers.first_name as endname')
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.created_by')
            ->where('planmasters.maintenance_type','=','Reactive')
            ->where('planmasters.ticket_status', '=', 'open')
            ->whereNull('assigned_to_userid');
            $reactiveUnassignTicket = $tmpRUT->get();
            $myunassign = $tmpRUT->count();

            // All open ticket
            $tmpAOT = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','users.first_name as uname','equipment.minor','equipment.major','endusers.first_name as endname' )
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
            ->where('planmasters.ticket_status', '=', 'open');
            $allOpenTicket = $tmpAOT->get();
            $myopencount = $tmpAOT->count();

            // All close ticket
            $tmpEC = DB::table('planmasters')
            ->select('planmasters.*','equipment.equipment_name','users.first_name as uname','equipment.minor','equipment.major','endusers.first_name as endname' )
            ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
            ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
            ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
            ->where('planmasters.ticket_status', '=', 'close');
            $allCloseTicket = $tmpEC->get();
            $myclosecount = $tmpEC->count();

        }
        if($logUserRole == 2) {
            // Add note to ticket
            $addNotetoTicket = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
            ->where('planmasters.ticket_status', '=', 'open')
            ->where('planmasters.enduser_id','=',$logUser)
            ->whereBetween('planmasters.plan_date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->get(['E.equipment_name','E.major','E.minor','planmasters.*']);
        }
        // Dashboard Counts
        $log = Auth::user()->id;
        $log2 = Auth::user()->first_name;
        $usercount = DB::table('users')->where('deleted_at',null)->count();
        $companiescount = DB::table('companies')->count('name');
        $departmentscount = DB::table('departments')->count();
        $equipmentcount = DB::table('equipment')->count();
        $vendorscount = DB::table('vendors')->count();
        $pmtodaycount = DB::table('planmasters')->whereDate('plan_date' ,'=',date('Y-m-d'))->where('planmasters.maintenance_type', '=', 'Preventive')->count();        

        $data = [
            'usersAssign'=>$usersAssign,
            'openTicketEng'=>$openTicketEng,
            'TodayEngPMPlan'=>$TodayEngPMPlan,
            'reactiveUnassignTicket'=>$reactiveUnassignTicket,
            'eng_close'=> $eng_close,
            'reactive_rejected'=> $reactive_rejected ,
            'CompletedPreventivePlan'=> $CompletedPreventivePlan ,
            'pmplanlist'=> $pmplanlist ,
            'openTicketEnduser'=> $openTicketEnduser ,
            'users'=> $users ,
            'companiescount'=> $companiescount ,
            'usercount'=> $usercount ,
            'departmentscount'=> $departmentscount ,
            'equipmentcount'=> $equipmentcount ,
            'vendorscount'=> $vendorscount ,
            'log'=> $log ,
            'log2'=> $log2 ,
            'pmtodaycount'=> $pmtodaycount ,
            'myopencount'=> $myopencount ,
            'myclosecount'=> $myclosecount ,
            'myunassign'=> $myunassign ,
            'allOpenTicket'=> $allOpenTicket ,
            'allCloseTicket'=> $allCloseTicket ,
            'addNotetoTicket' => $addNotetoTicket
        ];
        
        return View::make("dashboard.index")->with($data)->render();
    }

    public function showcalender(Request $request)
    {
        $plan = Planmaster::leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->leftjoin('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.id', '=', $request->id)
        ->get(['E.equipment_name','E.minor','E.major','users.first_name','users.last_name','planmasters.*'])->first();
        return response()->json($plan);
    }
    function updatePreventiveStatus(Request $request)
    {
        $yes =  Planmaster::whereIn('uniqueid', $request->id)->update(['ticket_status' => 'open']);

        // $details = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        // ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        // ->whereIn('planmasters.uniqueid', '=', $request->id)
        // ->get(['E.equipment_name','E.minor','E.major',DB::raw("CONCAT(users.first_name,' ',users.last_name) as assigned_user"),'planmasters.frequancy','planmasters.id','planmasters.maintenance_type','planmasters.plan_date','planmasters.ticket_status','planmasters.enduser_status','planmasters.plan_date'])->first();

        // $equipdata = Planmaster::leftjoin('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        // ->whereIn('planmasters.id', '=', $request->id)
        // ->get(['planmasters.enduser_id','E.department_id','planmasters.actual_done_by','planmasters.assigned_to_userid','planmasters.created_by'])->first();
        
        // $deptId = $equipdata->department_id;        
        // $user_list = [];
        // $hodid = User::where('department_id',$deptId)->where('Role',5)->get("id")->first();
        // $user_list['hodid'] = $hodid->hod_id;
        // $user_list['user_id'] = $equipdata->user_id;
        // $user_list['actual_done_by'] = $equipdata->actual_done_by;
        // $user_list['assigned_to_userid'] = $equipdata->assigned_to_userid;
        // $user_list['created_by'] = $equipdata->created_by;

        // $user_list = array_unique($user_list);

        // $user_arry = User::select("email")->whereIn('id',$user_list)->get();
        // $user_mail = [];
        // foreach($user_arry as $user){
        //     $user_mail[] = $user->email;
        // }
        // $file = 'pmstatus';
        // \Mail::to($user_mail)->send(new \App\Mail\PreventiveMail($details,$file));

        return response()->json(['msg'=>1]);
    }

    public function ajaxUpdate(Request $request)
    {

        $event = Planmaster::find($request->id)->update([
            'plan_date' => $request->start
        ]);

        $details = Planmaster::join('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.id', '=', $request->id)
        ->get(['E.equipment_name','E.minor','E.major',DB::raw("CONCAT(users.first_name,' ',users.last_name) as assigned_user"),'planmasters.frequancy','planmasters.id','planmasters.maintenance_type','planmasters.plan_date','planmasters.ticket_status','planmasters.plan_date'])->first();

        $equipdata = Planmaster::join('equipment as E', 'E.id', '=', 'planmasters.equipment_id')
        ->where('planmasters.id', '=', $request->id)
        ->get(['planmasters.enduser_id','E.department_id','planmasters.actual_done_by','planmasters.assigned_to_userid','planmasters.created_by'])->first();
        
        $deptId = $equipdata->department_id;        
        $user_list = [];
        $hodid = User::where('department_id',$deptId)->where('Role',1)->get("id")->first();
        $user_list['hodid'] = $hodid->hod_id;
        $user_list['user_id'] = $equipdata->user_id;
        $user_list['actual_done_by'] = $equipdata->actual_done_by;
        $user_list['assigned_to_userid'] = $equipdata->assigned_to_userid;
        $user_list['created_by'] = $equipdata->created_by;

        $user_list = array_unique($user_list);

        $user_arry = User::select("email")->whereIn('id',$user_list)->get();
        $user_mail = [];
        foreach($user_arry as $user){
            $user_mail[] = $user->email;
        }
        
        $file = 'pmstatus';
        // \Mail::to($user_mail)->send(new \App\Mail\PreventiveMail($details,$file));

        return response()->json(['msg'=>1]);
    }

}