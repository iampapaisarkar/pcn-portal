<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MEPTP\MEPTPApplicationRequest;
use App\Models\MEPTPApplication;
use DB;

class MEPTPApplicationController extends Controller
{
    public function applicationSubmit(Request $request){

        try {
            DB::beginTransaction();

            // dd($request->file('birth_certificate')->getClientOriginalName());
            $birth_certificate = app('App\Http\Services\FileUpload')->upload($request->file('birth_certificate'), $private = true);

            dd($birth_certificate);

            // Store MEPTP application 
            MEPTPApplication::create([
                'birth_certificate' => $request->name,
                'educational_certificate' => $request->name,
                'academic_certificate' => $request->name,
                'shop_name' => $request->shop_name,
                'shop_phone' => $request->shop_phone,
                'shop_email' => $request->shop_email,
                'shop_address' => $request->shop_address,
                'city' => $request->city,
                'state' => $request->state,
                'lga' => $request->lga,
                'is_registered' => $request->is_registered,
                'ppmvl_no' => $request->ppmvl_no,
                'school' => $request->school,
            ]);

            DB::commit();

            return back()->with('success','MEPTP Application successfully submited to state office');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
