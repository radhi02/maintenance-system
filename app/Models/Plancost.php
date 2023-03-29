<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plancost extends Model
{
    use HasFactory;
    protected $fillable = [
        'detail','type','cost','remark','plan_id'
    ];

}
