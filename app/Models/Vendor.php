<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_name', 'vendor_code', 'vendor_contactperson', 'vendor_email', 'vendor_phone', 'vendor_street', 'vendor_city', 'vendor_state', 'vendor_country', 'vendor_zipcode', 'company_id', 'vendor_status'
    ];

}
