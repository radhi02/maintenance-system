<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Department;
use App\Models\City;
use App\Models\Unit;
use Auth;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use DB;

class UserController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:User-index|User-create|User-edit|User-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:User-create', ['only' => ['create','store']]);
         $this->middleware('permission:User-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:User-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('User-index')) {
            $users = User::leftJoin('roles as r', 'r.id', '=', 'users.Role')
            ->leftJoin('departments as d', 'd.id', '=', 'users.department_id')
            ->where('deleted_at',NULL)
            ->get(['users.id', 'users.first_name', 'users.last_name', 'users.email','users.user_status','r.name as rolename','d.name as deptname']);
            return view("Users.index", compact("users"));
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
        if(auth()->user()->can('User-create')) {
            /* Current Login User Details */
            $user = Auth::user();
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $roles = Role::all();
            $edit_users = "";
            $Countries = "";
            $States = "";
            $Cities = "";
            $fetchCountry = Country::select("name", "id")->get();
            return view('Users.create', compact('edit_users', 'roles', 'fetchCountry', 'States', 'Cities','units'));
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }
    public function fetchDepartment(Request $request)
    {
        $data['departments'] = Department::where("unit_id",$request->unit_id)->where('status', 1)->get(["name", "id"]);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('User-store')) {
        $user_lastid = userLastID();
        $get_perfectLast_id = str_pad($user_lastid, 4, '0', STR_PAD_LEFT);

        $user = Auth::user();
        $img = $request->file('image');

        if (!empty($img) && $img->getClientOriginalName() != "")
        {
            $filename = $img->getClientOriginalName();
            $img->move(public_path('Users') , $filename);
        }

        $request->validate([
            'firstName' => 'required',
            'email' => 'required|email|unique:users',
            'lastName' => 'required',
            'Phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|min:8|max:12|regex:/^([0-9\s\-\+\(\)]*)$/',
            Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols()
            ->uncompromised(),
            'UserType' => 'required',
            'user_country' => 'required',
            'user_state' => 'required',
            'user_city' => 'required' , 'Status' => 'required',
            'department_id' => 'required',
            'unit_id' => 'required'
        ]);

        $users = User::create(['first_name' => $request->firstName, 'last_name' => $request->lastName, 'email' => $request->email,'Phone' => $request->Phone, 'password' => Hash::make($request->password) , 'company_id' => $user->company_id , 'department_id' => $request->department_id , 'unit_id' => $request->unit_id ,'Role' => $request->UserType, 'Country' => $request->user_country, 'State' => $request->user_state, 'city' => $request->user_city, 'emp_code'=>$get_perfectLast_id , 'user_status' => $request->Status, 'Image' => (isset($filename) ? $filename : NULL) , ]);

        $users->assignRole($request->UserType);

        session()->flash('msg', 'User Created Successfuly.');
        return redirect()->route('user.index');
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
        if(auth()->user()->can('User-show')) {
            $edit_users = User::findOrFail($id);
            $roles = Role::all();
            $Countries = Country::findOrFail($edit_users->Country);
            $States = State::findOrFail($edit_users->State);
            $Cities = City::findOrFail($edit_users->city);
            $Department = Department::findOrFail($edit_users->department_id);
            $Unit = Unit::findOrFail($edit_users->unit_id);
            return view('Users.show', compact('edit_users', 'Countries', 'States', 'Cities', 'Department', 'Unit'));
        } else {
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
        if(auth()->user()->can('User-edit')) {
            $user = Auth::user();
            $roles = Role::all();
            $edit_users = User::findOrFail($id);
            $units = Unit::select("name", "id")->where('status', 1)->get();
            $departments = Department::select("name", "id")->where([['status', '=', '1'],['unit_id', '=', $edit_users->unit_id]])->get();

            $country = Country::select("name", "id")->where('id', $edit_users->Country)->get()->first();
            $state = State::where('country_id',$edit_users->Country)->get();
            $city = City::where('state_id',$edit_users->State)->get();
            $fetchCountry = Country::select("name", "id")->get();
            return view('Users.create',compact('edit_users','roles','country','state','city','fetchCountry','departments','units'
            ));
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
        if(auth()->user()->can('User-update')) {
            $img = $request->file('image');
            if (!empty($img) && $img->getClientOriginalName() != "")
            {
                $filename = $img->getClientOriginalName();
                $img->move(public_path('Users') , $filename);
            } else {
                $filename = $request->image_2;
            }
            $request->validate([
                'firstName' => 'required',
                'email' => 'unique:users,email,' . $id, 
                'lastName' => 'required',
                'Phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'password' => 'required',
                'UserType' => 'required',
                'user_country' => 'required',
                'user_state' => 'required',
                'user_city' => 'required' , 'Status' => 'required',
                'department_id' => 'required',
                'unit_id' => 'required'
            ]);

            $User = User::find($id);
            $User->first_name = $request->firstName;
            $User->last_name = $request->lastName;
            $User->email= $request->email ;
            $User->department_id = $request->department_id;
            $User->unit_id = $request->unit_id;
            $User->Role = $request->UserType;
            $User->Country = $request->user_country;
            $User->State = $request->user_state;
            $User->city = $request->user_city;
            $User->user_status = $request->Status;
            $User->Phone = $request->Phone;
            // $User->Image = (isset($filename) ? $filename : NULL);
            if(isset($filename)){     $User->Image=$filename;}
            $User->save();  
            
            DB::table('model_has_roles')->where('model_id',$id)->delete();              
            $User->assignRole($request->UserType);
            session()->flash('msg', 'User Updated Successfuly.');
            return redirect()->route('user.index');
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
    public function destroy(User $user)
    {   
        if(auth()->user()->can('User-destroy')) {
            $user->delete();       
            return redirect()->route('user.index')->with('success','User deleted successfully');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    public function Status(Request $request)
    {
        $id_array = $request->id;
        $flag = $request->value;
        $Roles = User::whereIn('id', $id_array)->update(["user_status" => $flag]);
        if ($Roles == true)
        {
            return response()->json(['msg' => 1]);
        }
        else
        {
            return response()
                ->json(['msg' => 0]);
        }
        
    }
}