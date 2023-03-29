<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\Equipment;
use App\Models\Planmaster;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use App\Exports\ReactiveMaintenancesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use PDF;
use View;

class ReportReactiveController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:ReportReactive-index|ReportReactive-create|ReportReactive-edit|ReportReactive-destroy', ['only' => ['index','show']]);
        //  $this->middleware('permission:ReportReactive-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:ReportReactive-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:ReportReactive-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $auth = Auth::user();
        $Enduser = User::select("first_name", "last_name", "id")->where('user_status', '=', 'Active')->where('Role', '=', '2')->get();
        $Enguser = User::select("first_name", "last_name", "id")->where('user_status', '=', 'Active')->where('Role', '=', '3')->get();
        $units = Unit::select("name", "id")->where('status', 1)->get();
        $vendor = Vendor::select("vendor_name", "id")->get();
        $equipment = Equipment::select("equipment_name", "id")->where('equipment_status', '=', 'Active')->get();
        return view('reports.reactive_report', compact('Enguser','Enduser','units','vendor','equipment'));
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
        //
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
        //
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
    
    public function export(Request $request) {
        $daterange = explode(" - ",$request->daterange);
        $startDate = date("Y-m-d H:i:s", strtotime($daterange[0]));
        $endDate = date("Y-m-d H:i:s", strtotime($daterange[1]));

        $user=$request->user;
        $vendor=$request->vendor;
        $departments=$request->department;
        $equipment=$request->equipment;
        return Excel::download(new ReactiveMaintenancesExport($startDate, $endDate, $user, $vendor, $departments, $equipment), 'ReactiveMaintenances.xlsx');
    }
    public function getdata(Request $request)
    {
        $data1 = $this->reportData($request);
        return View::make("ReactivePlan")->with("data", $data1)->render();
    }

    public function createPDF(Request $request) {
        $data = $this->reportData($request);
        $pdf = PDF::loadView('pdf.Reactivepdf', compact('data'))->setPaper('a4', 'landscape');;
        $path = public_path('pdf/'); 
        $fileName =  time().'.'. 'pdf' ; 
        $pdf->save($path . '/' . $fileName); 
        $pdf = public_path('pdf'.DIRECTORY_SEPARATOR.$fileName);
        $pdf = str_replace('\\', '/', $pdf);
        $returnFName = URL::to('').'/'.'pdf'.'/'.$fileName;
        return response()->json($returnFName);
    }

    public function reportData($request) {

        $daterange = explode(" - ",$request->daterange);
        $startDate = date("Y-m-d H:i:s", strtotime($daterange[0]));
        $endDate = date("Y-m-d H:i:s", strtotime($daterange[1]));
        $end_user=$request->end_user;
        $eng_user=$request->eng_user;
        $vendor=$request->vendor;
        $departments=$request->department;
        $unit=$request->unit;
        $equipment=$request->equipment;
        $status=$request->status;

        $data = DB::table('planmasters')
        ->select('planmasters.*', 'equipment.equipment_name as ename', 'endusers.first_name as endname','engusers.first_name as uname','vendors.vendor_name as vname','departments.name as dname','units.name as unitname')
        ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
        // ->leftjoin('users', 'users.id', '=', 'planmasters.assigned_to_userid')
        ->leftjoin('users as engusers', 'engusers.id', '=', 'planmasters.assigned_to_userid')
        ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
        ->leftjoin('vendors', 'vendors.id', '=', 'equipment.vendor_id')
        ->leftjoin('departments', 'departments.id', '=', 'equipment.department_id')
        ->leftjoin('units', 'units.id', '=', 'equipment.unit_id')
        ->orderBy('planmasters.id', 'DESC')
        ->where('planmasters.maintenance_type','=','Reactive')
        ->whereBetween('planmasters.plan_date', [$startDate, $endDate]);

        if($end_user != 'All User') 
        {
            $data->where(function($query) use ($end_user){
                $query->Where('planmasters.enduser_id',$end_user);
            });
        } 
        if($eng_user != 'All User') 
        {
            $data->where(function($query) use ($eng_user){
                $query->Where('planmasters.assigned_to_userid',$eng_user); 
            });
        }
        if($vendor != 'All Vendor') 
        {
            $data->where(function($query) use ($vendor){
                $query->Where('equipment.vendor_id',$vendor);
            });
        } 
        if($departments != 'All Departments') 
        {
            $data->where(function($query) use ($departments){
                $query->Where('equipment.department_id',$departments);
            });
        } 
        if($unit != 'All Unit') 
        {
            $data->where(function($query) use ($unit){
                $query->Where('equipment.unit_id',$unit);
            });
        } 
        if($equipment != 'All Equipment') 
        {
            $data->where(function($query) use ($equipment){
                $query->Where('planmasters.equipment_id',$equipment);
            });
        }         
        if($status != 'All') 
        {
            $data->where(function($query) use ($status){
                $query->Where('planmasters.ticket_status',$status);
            });
        }
        $data1 = $data->get();
        return $data1;
    }
}
