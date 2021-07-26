<?php

namespace App\Http\Controllers\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MEPTPApplication;
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

            return view('checkout.checkout-meptp', compact('user', 'amount', 'token'));
        }else{
            return abort(404);
        }
        
    }

    public function paymentError($token){

        if(Payment::where('token', $token)->exists()){

            $order = Payment::where('token', $token)
            ->with('user', 'service')->first();

            // Payment::where('token', $token)->update([
            //     'token' => null
            // ]);

            return view('checkout.error', compact('order'));
        }else{
            return abort(404);
        }
        
    }

    public function paymentSuccess($token, Request $request){

        if(Payment::where('token', $token)->exists()){

            $order = Payment::where('token', $token)
            ->with('user', 'service')->first();

            // amount: 317.5
            // message: ""
            // paymentReference: "280008234371"
            // processorId: ""
            // transactionId: "b06fc14a6a534a41b1578b98e7a69101"
            $reference_id = $request->ref;
            $total_amount = $request->am;
            $service_charge = floatval($request->am - $order->amount);

            Payment::where('token', $token)->update([
                'token' => null,
                'status' => true,
                'reference_id' => $reference_id,
                'total_amount' => $total_amount,
                'service_charge' => $service_charge,
            ]);

            MEPTPApplication::where(['id' => $order->application_id, 'vendor_id' => Auth::user()->id])->update([
                'payment' => true
            ]);

            return view('checkout.success', compact('order'));
        }else{
            return abort(404);
        }
        
    }
}
