<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MEPTPApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'birth_certificate', 'educational_certificate', 'academic_certificate',
        'shop_name', 'shop_phone', 'shop_email', 'shop_address', 'city', 
        'state', 'lga', 'is_registered', 'ppmvl_no', 'traing_centre', 'status'
    ];
}
