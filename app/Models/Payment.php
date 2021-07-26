<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'order_id', 'reference_id', 'application_id', 'service_id', 'service_type', 'amount', 'service_charge',
        'total_amount', 'status', 'token'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function service() {
        return $this->hasOne(Service::class,'id', 'service_id');
    }
}
