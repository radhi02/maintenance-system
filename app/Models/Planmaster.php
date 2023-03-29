<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planmaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniqueid',
        'equipment_id',
        'Problem',
        'ticket_date',
        'criticality',
        'ticket_status',
        'created_by',
        'frequancy',
        'tasktype',
        'maintenance_type',
        'start_date',
        'plan_date',
        'assigned_to_userid',
        'loss_hrs',
        'service_cost_external_vendor',
        'actual_done_by',
        'actual_start_date',
        'actual_end_date',
        'plan_status',
        'remark_by_enginner',
        'remark_by_manager',
        'worknote',
        'done_task_list',
        'task_json'
    ];

}
