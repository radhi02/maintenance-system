<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Department;
use App\Models\Equipment;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;


class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Equipment-index|Equipment-create|Equipment-edit|Equipment-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:Equipment-create', ['only' => ['create','store']]);
         $this->middleware('permission:Equipment-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Equipment-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('Equipment-index')) {
            $equipment = DB::table('equipment')
                ->select('equipment.*','companies.name as cname','units.name as unitname','departments.name as dname','users.first_name as uname','vendors.vendor_name as vname' )
                ->join('companies', 'companies.id', '=', 'equipment.company_id')
                ->join('units', 'units.id', '=', 'equipment.unit_id')
                ->join('departments', 'departments.id', '=', 'equipment.department_id')
                ->join('users', 'users.id', '=', 'equipment.user_id')
                ->join('vendors', 'vendors.id', '=', 'equipment.vendor_id')
            ->get();
            return view('equipment.index',compact('equipment'));
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
        if(auth()->user()->can('Equipment-create')) {
            $user = Auth::user();
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $users = User::select("first_name", "last_name","id")->where('Role', '=', 2)->get();
            $vendor = Vendor::select("vendor_name","id")->get();
            return view('equipment.create',compact('units','users','vendor'));
        } else {
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
        if(auth()->user()->can('Equipment-store')) {
            $request->validate([
                'equipment_name'=>'required',
                'equipment_code'=>'required',
                'serial_no'=>'required',
                'user_id'=>'required',
                'unit_id'=>'required',
                'department_id'=>'required',
                'warranty_status'=>'required',
                'equipment_status'=>'required'
            ]);

            $fileName = NULL;
            if(isset($request->invoiceFile)){
                $invoiceFile = $request->invoiceFile?$request->invoiceFile:NULL;
                if (!empty($invoiceFile))
                {
                    $fileName = time().'.'.$request->invoiceFile->extension();  
                    $request->invoiceFile->move(public_path('EquipmentInvoices'), $fileName);
                }
            }
            // dd($request->all());
            $user = Auth::user();
            $equipment = new Equipment();
            $equipment->equipment_name=$request->equipment_name;
            $equipment->equipment_code=$request->equipment_code;
            $equipment->serial_no=$request->serial_no;
            $equipment->equipment_make=$request->equipment_make;
            $equipment->equipment_capacity=$request->equipment_capacity;
            $equipment->location=$request->location;
            $equipment->purchase_date=$request->purchase_date;
            $equipment->purchase_cost=$request->purchase_cost;
            $equipment->warranty_date=$request->warranty_date?$request->warranty_date:NULL;
            $equipment->warranty_status=$request->warranty_status;
            $equipment->company_id=$user->company_id;
            $equipment->vendor_id=$request->vendor_id;
            $equipment->department_id=$request->department_id;
            $equipment->unit_id=$request->unit_id;
            $equipment->equipment_status=$request->equipment_status;
            $equipment->user_id=$request->user_id;
            $equipment->invoiceFile=$fileName;
            $equipment->save();
            return redirect()->route('equipment.index')->with('success','Equipment created successfully');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        if(auth()->user()->can('Equipment-show')) {
            $Department = Department::findOrFail($equipment->department_id);
            $Unit = Unit::findOrFail($equipment->unit_id);
            return view('equipment.show',compact('equipment','Department','Unit'));
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        if(auth()->user()->can('Equipment-edit')) {
            $companies = Company::select("name", "id")->get();
            $departments = Department::select("name", "id")->where([['status', '=', '1'],['unit_id', '=', $equipment->unit_id]])->get();
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $users = User::select("first_name", "last_name","id")->where('Role', '=', 2)->get();
            $vendor = Vendor::select("vendor_name","id")->get();
            return view('equipment.create',compact('equipment','companies','units','users','vendor','departments'));
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        if(auth()->user()->can('Equipment-update')) {

            $request->validate([
                'equipment_name'=>'required',
                'equipment_code'=>'required',
                'serial_no'=>'required',
                'user_id'=>'required',
                'unit_id'=>'required',
                'department_id'=>'required',
                'warranty_status'=>'required',
                'equipment_status'=>'required'
            ]);
            $fileName = NULL;
            if ($file = $request->file('invoiceFile')) {
                if($request['oldfilename'] != NULL) {
                    if(file_exists(public_path("EquipmentInvoices".DIRECTORY_SEPARATOR .$request['oldfilename']))){
                        unlink(public_path("EquipmentInvoices".DIRECTORY_SEPARATOR .$request['oldfilename']));
                    }
                }
                $fileName = $request->file('invoiceFile')->getClientOriginalName();  
                $request->invoiceFile->move(public_path('EquipmentInvoices'), $fileName);         
            } 

            $user = Auth::user();
            $UpdateDetails = Equipment::where('id',$equipment->id)->update([
                'equipment_name'=>$request->equipment_name,
                'equipment_code'=>$request->equipment_code,
                'serial_no'=>$request->serial_no,
                'equipment_make'=>$request->equipment_make,
                'equipment_capacity'=>$request->equipment_capacity,
                'location'=>$request->location,
                'purchase_date'=>$request->purchase_date,
                'purchase_cost'=>$request->purchase_cost,
                'warranty_date'=>$request->warranty_date,
                'equipment_status'=>$request->equipment_status,
                'warranty_status'=>$request->warranty_status,
                'company_id'=>$user->company_id,
                'unit_id'=>$user->unit_id,
                'vendor_id'=>$request->vendor_id,
                'department_id'=>$request->department_id,
                'user_id'=>$request->user_id,
                'invoiceFile'=>$fileName
            ]);
        
            return redirect()->route('equipment.index')->with('success','Equipment updated successfully');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }
    public function downloadInvoiceFile($fpath)
    {
        $myFile = public_path("EquipmentInvoices".DIRECTORY_SEPARATOR .$fpath);
    	return response()->download($myFile);
    }
    public function deleteInvoicefile(Request $request)
    {
        if(file_exists(public_path("EquipmentInvoices".DIRECTORY_SEPARATOR .$request['filename']))){
            unlink(public_path("EquipmentInvoices".DIRECTORY_SEPARATOR .$request['filename']));
            $UpdateDetails = Equipment::where('id',$request['id'])->update([
                'invoiceFile'=>NULL
            ]);      
            return response()->json(['msg'=>1]);
        }else{
            return response()->json(['msg'=>2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        if(auth()->user()->can('Equipment-destroy')) {
            $equipment->delete();
            return redirect()->route('equipment.index')->with('success','Equipment deleted successfully');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }
}
