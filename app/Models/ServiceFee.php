<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function metas() {
        return $this->hasMany(ServiceFeeMeta::class,'service_fee_id', 'id');
    }
}
