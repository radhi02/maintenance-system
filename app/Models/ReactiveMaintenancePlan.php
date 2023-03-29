<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactiveMaintenancePlan extends Model
{
    use HasFactory;
    protected $table = 'reactive_maintenances_plans'; 
    protected $fillable = [
        'equipment_id', 'date',  'Problem','user_id','sdate','stime','edate','etime','no_loss_repair_hur','loss_repair_hur','cost_servies','MTBF','note','status','last_status','ticket_status'
   ];
}