<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use DB;

class CheckoutController extends Controller
{
    public function checkoutMEPTP(Request $request){

        $service = Service::where('id', 1)->with('fees')->first();

        $totalAmount = 0;

        foreach($service->fees as $fee){
            $totalAmount += $fee->amount;
        }

        return view('vendor-user.meptp-application');
    }
}
