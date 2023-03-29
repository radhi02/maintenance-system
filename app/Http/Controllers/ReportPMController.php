<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\Equipment;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use App\Exports\PMMaintenancesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use PDF;
use View;

class ReportPMController extends Controller
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
        return view('reports.pm_report', compact('Enduser','Enguser','units','vendor','equipment'));
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
    
    public function pmexport(Request $request){
        $daterange = explode(" - ",$request->daterange);
        $startDate = date("Y-m-d H:i:s", strtotime($daterange[0]));
        $endDate = date("Y-m-d H:i:s", strtotime($daterange[1]));

        $user=$request->user;
        $vendor=$request->vendor;
        $departments=$request->department;
        $equipment=$request->equipment;
        return Excel::download(new PMMaintenancesExport($startDate, $endDate, $user, $vendor, $departments, $equipment), 'PMMaintenancesExport.xlsx');
    }

    public function createPMPDF(Request $request) {
        $data = $this->getReportData($request);
        $pdf = PDF::loadView('pdf.pmpdf', compact('data'))->setPaper('a4', 'landscape');;
        $path = public_path('pdf/'); 
        $fileName =  time().'.'. 'pdf' ; 
        $pdf->save($path . '/' . $fileName); 
        $pdf = public_path('pdf'.DIRECTORY_SEPARATOR.$fileName);
        $pdf = str_replace('\\', '/', $pdf);
        $returnFName = URL::to('').'/'.'pdf'.'/'.$fileName;
        return response()->json($returnFName);
    }
    
    public function getpmdata(Request $request)
    {
        $data1 = $this->getReportData($request);
        return View::make("mytemplate")->with("data", $data1)->render();
    }

    public function getReportData($request) {
        $daterange = explode(" - ",$request->daterange);
        $startDate = date("Y-m-d H:i:s", strtotime($daterange[0]));
        $endDate = date("Y-m-d H:i:s", strtotime($daterange[1]));
        $end_user_id=$request->end_user_id;
        $eng_user_id=$request->eng_user_id;
        $vendor=$request->vendor;
        $departments=$request->department;
        $unit=$request->unit;
        $equipment=$request->equipment;
        $status=$request->status;
        $data = DB::table('planmasters')
        ->select('planmasters.*', 'equipment.equipment_name as equipment_name','equipment.minor','equipment.major', 'engusers.first_name as uname', 'endusers.first_name as endname','vendors.vendor_name as vname','departments.name as dname','units.name as unitname')
        ->leftjoin('equipment', 'equipment.id', '=', 'planmasters.equipment_id')
        ->leftjoin('users as engusers', 'engusers.id', '=', 'planmasters.assigned_to_userid')
        ->leftjoin('users as endusers', 'endusers.id', '=', 'planmasters.enduser_id')
        ->leftjoin('vendors', 'vendors.id', '=', 'equipment.vendor_id')
        ->leftjoin('departments', 'departments.id', '=', 'equipment.department_id')
        ->leftjoin('units', 'units.id', '=', 'equipment.unit_id')
        ->orderBy('planmasters.id', 'DESC')
        ->where('planmasters.maintenance_type','=','Preventive')
        ->whereBetween('planmasters.plan_date', [$startDate, $endDate]);
        if($eng_user_id != 'All User') 
        {
            $data->where(function($query) use ($eng_user_id){
                $query->Where('planmasters.assigned_to_userid',$eng_user_id);
            });
        } 
        if($end_user_id != 'All User') 
        {
            $data->where(function($query) use ($end_user_id){
                $query->Where('planmasters.enduser_id',$end_user_id);
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
        $data->orderBy("planmasters.id");
        $data1 = $data->get();

        return $data1;
    }
}