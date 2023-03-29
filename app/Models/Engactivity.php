<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engactivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_id','actual_start_date','actual_end_date','loss_hrs'
    ];

}
