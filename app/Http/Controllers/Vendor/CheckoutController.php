<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use DB;

class CheckoutController extends Controller
{
    public function checkoutMEPTP($token){

        $service = Service::where('id', 1)
        ->with('netFees')
        ->first();

        $totalAmount = 0;

        foreach($service->netFees as $fee){
            $totalAmount += $fee->amount;
        }
        
        return $totalAmount;
    }
}
