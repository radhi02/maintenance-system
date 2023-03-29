<?php

namespace App\Exports;

use App\Models\Planmaster;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class PMMaintenancesExport implements FromCollection, WithHeadings
{
    use Exportable;
    protected $startDate ;
    protected $endDate ;
    protected $user;
    protected $vendor;
    protected $department;
    protected $equipment;

    function __construct($startDate,$endDate, $user, $vendor, $department, $equipment) {
        $this->startDate = $startDate ;
        $this->endDate = $endDate ;
        $this->user = $user;
        $this->vendor = $vendor;
        $this->department = $department;
        $this->equipment = $equipment;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $startDate  = $this->startDate ;
        $endDate  = $this->endDate ; 
        $user=$this->user;
        $vendor=$this->vendor;
        $departments=$this->department;
        $equipment=$this->equipment;
        $data = DB::table('planmasters as t1')->select(
            "t1.id",
            "t2.equipment_name as ename",
            "t3.first_name as assigned_user_fname",
            "t3.last_name as assigned_user_lname",
            "t4.vendor_name as vname",
            "t5.name as dname",
            "t1.plan_date",
            "t1.loss_hrs",
            "t1.service_cost_external_vendor",
            "t6.first_name as actual_done_byf",
            "t6.last_name as actual_done_byl",
            "t1.actual_start_date",
            "t1.actual_end_date",
            "t1.remark_by_enginner",
            "t1.done_task_list",
            )->leftjoin('equipment as t2', 't2.id', '=', 't1.equipment_id')
            ->leftjoin('users as t3', 't3.id', '=', 't1.assigned_to_userid')
            ->leftjoin('vendors as t4', 't4.id', '=', 't2.vendor_id')
            ->leftjoin('departments as t5', 't5.id', '=', 't2.department_id')
            ->leftjoin('users as t6', 't6.id', '=', 't1.actual_done_by')
            ->orderBy('t1.id', 'DESC')
            ->where(function($query) use ($startDate,$endDate){
                $query->whereDate('t1.actual_start_date', '>=', $startDate);
                $query->whereDate('t1.actual_end_date', '<=', $endDate);
            });
           
            if($user != 'All User') 
            {
                $data->where(function($query) use ($user){
                    $query->Where('t1.assigned_to_userid',$user);
                });
            } 
            if($vendor != 'All Vendor') 
            {
                $data->where(function($query) use ($vendor){
                    $query->Where('t2.vendor_id',$vendor);
                });
            } 
            if($departments != 'All Departments') 
            {
                $data->where(function($query) use ($departments){
                    $query->Where('t2.department_id',$departments);
                });
            } 
            if($equipment != 'All Equipment') 
            {
                $data->where(function($query) use ($equipment){
                    $query->Where('t1.equipment_id',$equipment);
                });
            } 
           
            $data1 = $data->orderBy("t1.id")->get();

            $output = [];
            $count = 1;

            foreach ($data1 as $user)
            {
                $output[] = [
                    $count,
                    $user->ename,
                    $user->assigned_user_fname.' '.$user->actual_done_byl,
                    $user->vname,
                    $user->dname,
                    $user->plan_date,
                    $user->loss_hrs,
                    $user->service_cost_external_vendor,
                    $user->actual_done_byf.' '.$user->actual_done_byl,
                    $user->actual_start_date,
                    $user->actual_end_date,
                    $user->remark_by_enginner,
                    $user->done_task_list,
                    ];
                $count++;
            }
            // echo '<pre>'; print_r($output); die;
            // return collect($output);
            return collect($output);
    }

    public function headings(): array
    {
        return [
            "Sr No",
            "Equipment Name",
            "Assigned User",
            "Vendor name",
            "Department name",
            "Plan Date",
            "Loss Repair Hour",
            "Spare",
            "Cost of Servies From External Vendor",
            "MTBF (Days)",
            "Actual Done By",
            "Start Date",
            "End Date",
            "Remark By Enginner",
            "Done Task List",
            "Enginner Status",
            "Manager Status",
        ];
    }
}
