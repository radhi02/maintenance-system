<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactiveMaintenance extends Model
{
    use HasFactory;
    protected $fillable = [
         'equipment_id', 'date',  'Problem', 'status'
    ];
}
