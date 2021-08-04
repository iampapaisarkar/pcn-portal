<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPMVRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'meptp_application_id', 'ppmv_application_id', 'renewal_year', 'licence'
    ];
}
