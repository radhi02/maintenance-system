<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Session;
use Auth;
        
class RoleController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:Role-index|Role-create|Role-show|Role-destroy', ['only' => ['index','show']]);
        //  $this->middleware('permission:Role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:Role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:Role-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth()->user()->can('Role-index')) {
            $roles = Role::all();
            return view("Role.index",compact('roles'));
        // }else{
        //     $auth = Auth::user();
        //     return view('error.role_error',compact('auth'));
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('Role-index')) {

        // if(auth()->user()->can('Role-create')) 
        // {
        //     return view("Role.create");
        // }
            return view("Role.create");
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

        if(auth()->user()->can('Role-store')) 
        {
            $request->validate([
                'name' => 'required|unique:roles|max:255',
                'description' => 'required',
            ]);

            $role = Role::create(['name' =>$request->name,"status"=>$request->status,"description"=>$request->description]);
          
            session()->flash('msg', 'Role Created Successfuly.');
            
            return redirect()->route('role.index');
        // }
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
        if(auth()->user()->can('Role-store')) 
        {
       
            $role =  Role::find($id);

            return view("Role.show",compact('role'));
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
    public function edit($id)
    {
        if(auth()->user()->can('Role-store')) 
        {
            $edit_role = Role::find($id);
            return view("Role.create",compact("edit_role"));
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
        if(auth()->user()->can('Role-store')) 
        {
            $role = Role::where('id',$id)->update(['name' =>$request->name,"status"=>$request->status,"description"=>$request->description]);
            session()->flash('msg', 'Role Updated Successfuly.');
           return  redirect()->route('role.index');
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

    public function destroy(Role $role)
    {
        if(auth()->user()->can('Role-store')) 
        {
        $role->delete();
       
        return redirect()->route('role.index')->with('success','Role deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }


    public function Status(Request $request)
    {
        // if(auth()->user()->can('Role-store')) 
        // {
            $id_array = $request->id;
            $flag= $request->value;

            $Roles = Role::whereIn('id',$id_array)->update(["status"=>$flag]);
            if($Roles == true)
            {
                return response()->json(['msg'=>1]);
            }
            else
            {
                return response()->json(['msg'=>0]);
            }
        // }
       
    }
}
