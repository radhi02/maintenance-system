<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_id','start_date', 'frequancy', 'assigned_to_userid', 'scheduled_userid', 'status'
    ];

}
