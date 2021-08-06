<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PPMV\PPMVApplicationStoreRequest;
use App\Http\Requests\PPMV\PPMVApplicationUpdateRequest;
use App\Http\Services\FileUpload;
use App\Http\Services\Checkout;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
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
            ]);

            PPMVRenewal::create([
                'vendor_id' => Auth::user()->id,
                'meptp_application_id' => $meptp->id,
                'ppmv_application_id' => $application->id,
                'renewal_year' => date('Y'),
                'status' => 'pending',
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

    public function applicationFormEdit($id){

        $application = PPMVApplication::select('p_p_m_v_applications.*')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where('p_p_m_v_applications.id', $id)
        ->where('p_p_m_v_applications.vendor_id', Auth::user()->id)
        ->where(function($q){
            $q->where('p_p_m_v_renewals.status', 'rejected');
            $q->orWhere('p_p_m_v_renewals.status', 'unrecommended');
        })
        ->latest()
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('vendor-user.ppmv.ppmv-application-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function applicationFormUpdate(PPMVApplicationUpdateRequest $request, $id){

        try {
            DB::beginTransaction();

            if(PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $id])->exists()){

                $application = PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $id])->first();

                if($request->file('reference_1_letter') != null){
                    if($application->reference_1_letter == $request->file('reference_1_letter')->getClientOriginalName()){
                        $reference_1_letter = $application->reference_1_letter;
                    }else{
                        $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = true, 'ppmv', 'reference_1_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV'. DIRECTORY_SEPARATOR . $application->reference_1_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_1_letter = $application->reference_1_letter;
                }

                if($request->file('reference_2_letter') != null){
                    if($application->reference_2_letter == $request->file('reference_2_letter')->getClientOriginalName()){
                        $reference_2_letter = $application->reference_2_letter;
                    }else{
                        $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = true, 'ppmv', 'reference_2_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV'. DIRECTORY_SEPARATOR . $application->reference_2_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_2_letter = $application->reference_2_letter;
                }
                

                PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $id])
                ->update([
                    'vendor_id' => Auth::user()->id,
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
                    'created_at' => now(),
                ]);

                PPMVRenewal::where(['vendor_id' => Auth::user()->id, 'ppmv_application_id' => $id, 'renewal_year' => date('Y')])
                ->update([
                    'status' => 'pending',
                ]);

                $response = true;
               
            }else{
                $response = false;
            }

            DB::commit();

                if($response == true){
                    return redirect()->route('ppmv-renewal')
                    ->with('success', 'Application successfully updated');
                }else{
                    return back()->with('error','There is something error, please try after some time');
                }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
        
    }

    public function renewal(){

        $renewals = PPMVRenewal::where('vendor_id', Auth::user()->id)
        ->with('user', 'ppmv_application', 'meptp_application')
        ->orderBy('renewal_year')
        ->get();

        return view('vendor-user.ppmv.ppmv-renewal', compact('renewals'));
    }
}
