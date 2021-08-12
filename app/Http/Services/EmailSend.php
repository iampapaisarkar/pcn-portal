<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\MEPTPApplication;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use DB;
use Mail;
use App\Mail\PaymentSuccessEmail;

class EmailSend
{
    public static function sendEmailSuccessEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to(Auth::user()->email)->send(new PaymentSuccessEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }


}