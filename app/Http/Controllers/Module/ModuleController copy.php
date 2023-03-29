<?php
namespace App\Http\Controllers\Module;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
class ModuleController extends Controller
{
    function Create()
    {
        return view('Permissions.create');
    }
    function index($id)
    {
        $userid=$id;
        $permisson =  Permission::all();
        $parent0 = array();
        $parent1 = array();
        $parent = array();
        foreach( $permisson as $key=>$val)
        {
            if($val->moduleName != $id)
            {
                $parent[]=["id"=>$val->id,"Name"=>$val->moduleName];
                $id = $val->moduleName;
            }
        }
        $collection = new Collection();
        $collection =(object)(isset($parent))?$parent:$parent=[];
        $parent = $collection;
        return view('Permissions.index',compact('permisson','parent','userid'));
    }
    function store(Request $request)
    {
        $ModuleName =$request->ModuleName;
        if($request->ModuleType =='Sub-Maste')
        {
            $sub_master = $request->sub_master;
        }
        if($request->RouteType =="resource")
        {
            $route_array= array('index','create','store','show','edit','update','destroy');
        }
        else
        {
            $route_array= array($request->ModuleName);
        }
        $get_con_name= ($request->master!="")? $request->master: $request->sub_master;
        foreach($route_array as $key=>$value)
        {
            $permission = Permission::create(['name' => $get_con_name."-".$value, 'moduleName'=>$ModuleName]);
        }
        session()->flash('msg', 'Module Created Updated Successfuly.');
        return redirect()->back();
    }
    function GivePermission(Request $request)
    {
        $permisson_req =  $request->child;
        $user_id=  $request->user;
        $user= User::find($user_id);
        $role = Role::find( $user->Role);
        $modal = DB::table('model_has_permissions')->where('model_id',$user_id)->delete();
        foreach($permisson_req as $req)
        {
            $user->givePermissionTo($req);
        }
     return redirect()->route('user.index');
    }
}