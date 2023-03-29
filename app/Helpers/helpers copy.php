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

function CheckPermissionExitOrNot($Permisstion,$user_id)
{
    $user= User::find($user_id);
     $get = checkRole($user->Role);
      $main_selected_permission1 = DB::table('permissions as t1')
     ->leftJoin('model_has_permissions as t2','t1.id','=','t2.permission_id');
        if($get  !="Admin")
        {
            $main_selected_permission1->where('t2.model_id',"=",$user_id);
        }
        $main_selected_permission = $main_selected_permission1->get();
    //  dd($main_selected_permission);
    $array=array();
    foreach($main_selected_permission as $chekded_id)
    {
        $array[$chekded_id->id]=['cheked'=>$chekded_id->id];
    }
return  $array;
}
function checkRole($id)
{
    $role= Role::find($id);
    return $role->name;
}
