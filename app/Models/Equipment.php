<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_name', 'equipment_code', 'equipment_make', 'equipment_capacity', 'location', 'purchase_date', 'purchase_cost', 'warranty_date', 'equipment_status',  'warranty_status', 'vendor_id', 'company_id', 'department_id','unit_id','user_id'
    ];

}