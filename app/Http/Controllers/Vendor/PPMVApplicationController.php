<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PPMV\PPMVApplicationStoreRequest;
// use App\Http\Requests\PPMV\PPMVApplicationupdateRequest;
use App\Http\Services\FileUpload;
use App\Http\Services\Checkout;
use App\Models\PPMVApplication;
use DB;
use PDF;
use File;
use Storage;

class PPMVApplicationController extends Controller
{
    public function applicationForm(){

        $shop = Auth::user()->passed_meptp_application()->first();

        return view('vendor-user.ppmv.ppmv-application', compact('shop'));
    }

    public function applicationSubmit(PPMVApplicationStoreRequest $request){
        try {
            DB::beginTransaction();

            $meptp = Auth::user()->passed_meptp_application()->first();

            $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = true, 'ppmv', 'reference_1_letter');
            $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = true, 'ppmv', 'reference_2_letter');

            // Store MEPTP application 
            $application = PPMVApplication::create([
                'vendor_id' => Auth::user()->id,
                'meptp_application_id' => $meptp->id,
                'reference_1_name' => $request->reference_1_name,
                'reference_1_phone' => $request->reference_1_phone,
                'reference_1_email' => $request->reference_1_email,
                'reference_1_address' => $request->reference_1_address,
                'reference_1_letter' => $reference_1_letter,
                'current_annual_licence' => $request->current_annual_licence,
                'reference_2_name' => $request->reference_2_name,
                'reference_2_phone' => $request->reference_2_phone,
                'reference_2_email' => $request->reference_2_email,
                'reference_2_address' => $request->reference_2_address,
                'reference_2_letter' => $reference_2_letter,
                'reference_occupation' => $request->reference_occupation,
                'status' => 'send_to_state_offcie',
            ]);

            $response = Checkout::checkoutMEPTP($application = ['id' => $application->id], 'ppmv_registration');

            DB::commit();

                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Application successfully submitted. Please pay amount for further action');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }




    public function renewal(){
        return view('vendor-user.ppmv.ppmv-application', compact('shop'));
    }
}
