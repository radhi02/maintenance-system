<?php

namespace App\Exports;

use App\Models\ReactiveMaintenancePlan;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ReactiveMaintenancesExport implements FromCollection, WithHeadings
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
        $data = DB::table('plancost as t1')->select(
            "t6.id",
            "t2.equipment_name as ename",
            "t3.first_name as assigned_user_fname",
            "t3.last_name as assigned_user_lname",
            "t4.vendor_name as vname",
            "t5.name as dname",
            "t6.plan_date",
            "t6.Problem",
            "t6.loss_hrs",
            "t6.service_cost_external_vendor",
            "t6.actual_start_date",
            "t6.actual_end_date",
            "t1.detail",
            "t1.type",
            "t1.cost",
            "t1.remark",
            "t6.criticality",
            "t6.ticket_status",
        )
            ->join('planmasters as t6', 't6.id', '=', 't1.plan_id')
            ->join('equipment as t2', 't2.id', '=', 't6.equipment_id')
            ->join('users as t3', 't3.id', '=', 't6.assigned_to_userid')
            ->join('vendors as t4', 't4.id', '=', 't2.vendor_id')
            ->join('departments as t5', 't5.id', '=', 't2.department_id')
            ->where('t6.maintenance_type','=','Reactive')
            ->orderBy('t1.id', 'DESC')
           
            ->where(function($query) use ($startDate,$endDate){
                $query->whereDate('t6.plan_date', '>=', $startDate);
                $query->whereDate('t6.plan_date', '<=', $endDate);
            });
           
            if($user != 'All User') 
            {
                $data->where(function($query) use ($user){
                    $query->Where('t6.assigned_to_userid',$user);
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
                    $query->Where('t6.equipment_id',$equipment);
                });
            } 

           
            $data1 = $data->orderBy("t6.id")->get();

            $output = [];
            $count = 1;

            foreach ($data1 as $user)
            {
                $output[] = [
                    $count,
                    $user->ename,
                    $user->assigned_user_fname,
                    $user->vname,
                    $user->dname,
                    $user->plan_date,
                    $user->Problem,
                    $user->loss_hrs,
                    $user->service_cost_external_vendor,
                    $user->actual_start_date,
                    $user->actual_end_date,
                    $user->detail,
                    $user->type,
                    $user->cost,
                    $user->remark,
                    $user->criticality,
                    $user->ticket_status,
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
            "User Name",
            "Vendor_name",
            "Department name",
            "Request Date",
            "Problem",
            "Loss Repair Hour",
            "Cost of Servies From External Vendor",
            "MTBF (Days)",
            "Start Date",
            "End Date",
            "Cost Detail",
            "Cost Type",
            "Cost Price",
            "Cost Remark",
            "Criticality",
            "Ticket Status",
            "Enginner Status",
            "End-User Status",

        ];
    }
}
