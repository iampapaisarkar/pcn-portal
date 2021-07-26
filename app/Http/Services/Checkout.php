<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\MEPTPApplication;
use DB;
use File;
use Storage;
use Session;
use URL;

class Checkout
{
    public static function checkoutMEPTP($application){

        try {
            DB::beginTransaction();

            $meptp = MEPTPApplication::where(['id' => $application['id'], 'payment' => false])->first();

            if($meptp){

                $service = Service::where('id', 1)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                Payment::create([
                    'order_id' => 1,
                    // 'reference_id' => 1,
                    'application_id' => 1,
                    'service_id' => 1,
                    'service_type' => 1,
                    // 'amount' => 1,
                    // 'service_charge' => 1,
                    'total_amount' => 1,
                    // 'status' => 1,
                    'token' => 1,
                ]);

            }else{
                $response = ['sucess' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }


}