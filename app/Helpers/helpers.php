<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('vendorLastID')) {
    function vendorLastID()
    {
        $last = DB::table('vendors')->latest('id')->first('vendor_code');

        $get_perfectLast_id=0000;
        if(!empty($last))
        {
            $get_perfectLast_id  = $last->vendor_code;
            $get_perfectLast_id++;
        }
         if($get_perfectLast_id == 0000)
        {
            $get_perfectLast_id=0001;
        }

        return $get_perfectLast_id;
    }
}
if (! function_exists('unitLastID')) {
    function unitLastID()
    {
        $last = DB::table('units')->latest('id')->first('unit_code');

        $get_perfectLast_id=0000;
        if(!empty($last))
        {
            $get_perfectLast_id  = $last->unit_code;
            $get_perfectLast_id++;
        }
         if($get_perfectLast_id == 0000)
        {
            $get_perfectLast_id=0001;
        }

        return $get_perfectLast_id;
    }
}
if (! function_exists('companyLastID')) {
    function companyLastID()
    {   
        $get_perfectLast_id=0000;
        $last = DB::table('companies')->latest('id')->first('code');

        if(!empty($last))
        {
            $get_perfectLast_id  = $last->code;
            $get_perfectLast_id++;
        }
         if($get_perfectLast_id == 0000)
        {
            $get_perfectLast_id=0001;
        }
        
        return $get_perfectLast_id;
    }
}
if (! function_exists('departmentLastID')) {
    function departmentLastID()
    {
        $last = DB::table('departments')->latest('id')->first('code');

        $get_perfectLast_id=0000;
        if(!empty($last))
        {
            $get_perfectLast_id  = $last->code;
            $get_perfectLast_id++;
        }
         if($get_perfectLast_id == 0000)
        {
            $get_perfectLast_id=0001;
        }

        return $get_perfectLast_id;
    }
}
if (! function_exists('userLastID')) {
    function userLastID()
    {
        $last = DB::table('users')->latest('id')->first('emp_code');

        $get_perfectLast_id=0000;
        if(!empty($last))
        {
            $get_perfectLast_id  = $last->emp_code;
            $get_perfectLast_id++;
        }
         if($get_perfectLast_id == 0000)
        {
            $get_perfectLast_id=0001;
        }

        return $get_perfectLast_id;
    }
}
function checkRole($id)
{
     $role= Role::find($id);
     return $role->name;
}
function CheckPermissionExitOrNot($Permisstion,$role_id)
{
    $get = checkRole($role_id);
    $main_selected_permission = DB::table('permissions as t1')->Join('role_has_permissions as t2','t1.id','=','t2.permission_id')
    ->where('t2.role_id',$role_id)->get();
    
    $array=array();
    foreach($main_selected_permission as $chekded_id)
    {
    $array[$chekded_id->id]=['cheked'=>$chekded_id->id];
    }
    return  $array;
}

function StoreNewDateFormat($date)
{
    if($date !=""){ return $newDate = date("Y-m-d", strtotime($date)); }else { return false; }
}
function ShowNewDateFormat($date)
{
    if($date !=""){ return date("d-m-Y h:i:s",strtotime($date)); }else { return false; }
}




