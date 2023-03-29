<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Company;
use App\Models\Unit;
use App\Models\User;
use Auth;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Department-index|Department-create|Department-edit|Department-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:Department-create', ['only' => ['create','store']]);
         $this->middleware('permission:Department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Department-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('Department-index')) {
            $departments = Department::join('units', 'units.id', '=', 'departments.unit_id')
            ->leftJoin('users',function ($join) {
                $join->on('users.department_id', '=', 'departments.id') ;
                $join->where('users.Role', '=', 1) ;
            })
            ->get(['departments.id', 'departments.name', 'departments.code', 'departments.status', 'units.name as unitname','users.id as userid','users.first_name as hodfname','users.last_name as hodlname']);
            return view('departments.index',compact('departments'));
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
        if(auth()->user()->can('Department-create')) {
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $users = User::select("first_name", "last_name","id")->where('Role', 5)->get();
            return view('departments.create',compact('users','units'));
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
        if(auth()->user()->can('Department-store')) {

        $department_lastid = departmentLastID();
        $get_perfectLast_id = str_pad($department_lastid, 4, '0', STR_PAD_LEFT);

        $request->validate([
            'name' => 'required',
            'unit_id' => 'required',
            'status' => 'required'
        ]);
      
        $create = Department::create([
            'name'=> $request->name,
            'code'=>$get_perfectLast_id,
            'unit_id'=> $request->unit_id,                            
            'status'=>$request->status
        ]);   

        return redirect()->route('departments.index')->with('success','Department created successfully.');
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
    public function show(Department $department)
    {
        if(auth()->user()->can('Department-show')) {

        $department = Department::join('units', 'units.id', '=', 'departments.unit_id')
        ->leftJoin('users',function ($join) {
            $join->on('users.department_id', '=', 'departments.id') ;
         
        })
        ->get(['departments.id', 'departments.name', 'departments.code', 'departments.status','units.name as unitname','users.id as userid','users.first_name as hod'])->first();
        return view('departments.show',compact('department'));
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        if(auth()->user()->can('Department-edit')) {
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $users = User::select("first_name", "last_name","id")->where('Role', 5)->get();
            return view('departments.create',compact('department','units','users'));
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
    public function update(Request $request, Department $department)
    {
        if(auth()->user()->can('Department-update')) {

        $request->validate([
            'name' => 'required',
            'unit_id' => 'required',
            'status' => 'required'
        ]);
      
        $department->update($request->all());
      
        return redirect()->route('departments.index')->with('success','Department updated successfully');
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
    public function destroy(Department $department)
    {
        if(auth()->user()->can('Department-destroy')) {

        $department->delete();
        
        return redirect()->route('departments.index')->with('success','Department deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }
}