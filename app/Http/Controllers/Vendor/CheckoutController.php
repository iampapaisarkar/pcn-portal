<?php

namespace App\Http\Controllers\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use DB;

class CheckoutController extends Controller
{
    public function checkoutMEPTP($token){


        if(Payment::where('token', $token)->exists()){

            $user = Auth::user();
            $amount = Payment::where('token', $token)->first()->amount;

            return view('checkout.checkout-meptp', compact('user', 'amount'));
        }else{
            return abort(404);
        }
        
    }
}
