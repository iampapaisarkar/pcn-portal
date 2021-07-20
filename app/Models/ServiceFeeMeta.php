<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFeeMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_fee_id', 'description', 'amount', 'description', 'status'
    ];
}
