<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use DB;
use File;
use Storage;
use Session;
use URL;

class Checkout
{

    public static function checkoutMEPTP($application){

        $service = Service::where('id', 1)
        ->with('netFees')
        ->first();

        $totalAmount = 0;

        foreach($service->netFees as $fee){
            $totalAmount += $fee->amount;
        }

        // dd($application);

        return view('checkout.checkout-meptp');

    }


}