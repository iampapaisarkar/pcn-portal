<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'reference_id', 'application_id', 'service_id', 'service_type', 'amount', 'service_charge',
        'total_amount', 'status', 'token'
    ];
}
