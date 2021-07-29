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
        'state', 'lga', 'is_registered', 'ppmvl_no','traing_centre', 'batch_id', 'tier_id',  'status', 'query', 'payment'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function tier() {
        return $this->hasOne(Tier::class,'id', 'tier_id');
    }

    public function user_state() {
        return $this->hasOne(State::class,'id', 'state');
    }

    public function user_lga() {
        return $this->hasOne(Lga::class,'id', 'lga');
    }

    public function school() {
        return $this->hasOne(School::class,'id', 'traing_centre');
    }

    public function batch() {
        return $this->hasOne(Batch::class,'id', 'batch_id');
    }

}
