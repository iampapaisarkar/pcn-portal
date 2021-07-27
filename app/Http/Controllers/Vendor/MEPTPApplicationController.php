<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\FileUpload;
use App\Http\Services\Checkout;
use App\Http\Requests\MEPTP\MEPTPApplicationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use DB;
use Storage;

class MEPTPApplicationController extends Controller
{
    public function applicationForm(){

        return view('vendor-user.meptp-application');
    }
    
    public function applicationSubmit(MEPTPApplicationRequest $request){

        try {
            DB::beginTransaction();

            $birth_certificate = FileUpload::upload($request->file('birth_certificate'), $private = true);
            $educational_certificate = FileUpload::upload($request->file('educational_certificate'), $private = true);
            $academic_certificate = FileUpload::upload($request->file('academic_certificate'), $private = true);

            // Store MEPTP application 
            $application = MEPTPApplication::create([
                'vendor_id' => Auth::user()->id,
                'birth_certificate' => $birth_certificate,
                'educational_certificate' => $educational_certificate,
                'academic_certificate' => $academic_certificate,
                'shop_name' => $request->shop_name,
                'shop_phone' => $request->shop_phone,
                'shop_email' => $request->shop_email,
                'shop_address' => $request->shop_address,
                'city' => $request->city,
                'state' => $request->state,
                'lga' => $request->lga,
                'is_registered' => $request->is_registered == 'yes' ? true : false,
                'ppmvl_no' => $request->is_registered == 'yes' ? $request->ppmvl_no : NULL,
                'traing_centre' => $request->school,
                'batch_id' => Batch::where('status', true)->first()->id,
                'status' => 'pending',
            ]);

            $response = Checkout::checkoutMEPTP($application = ['id' => $application->id]);

            DB::commit();

                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Application successfully submitted. Please pay amount for further action');

            // if($response['success'] == true){
            //     return redirect()->route('checkout-meptp', ['token' => $response['token']]);
            // }else{
            //    return redirect('/')->with('error','There is something error, please try after some time');
            // }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function applicationStatus(){

        $application = MEPTPApplication::where('vendor_id', Auth::user()->id)
        ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')->where('batches.status', '=', true)
        ->with('user_state', 'user_lga', 'school', 'batch')
        ->first();

        return view('vendor-user.meptp-application-status', compact('application'));
    }

    public function applicationResult(){

        $application = MEPTPApplication::where('vendor_id', Auth::user()->id)
        ->with('user_state', 'user_lga', 'school', 'batch')
        ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')->where('batches.status', '=', true)
        ->first();

        return view('vendor-user.meptp-application-result', compact('application'));
    }

    public function downloadMEPTPDocument(Request $request){


        // dd($request->all());

        // birth_certificate
        // educational_certificate
        // academic_certificate

        if(Auth::user()->hasRole(['vendor'])){
            if($request->type == 'birth_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $request->id])->first()->birth_certificate;
            }
            if($request->type == 'educational_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $request->id])->first()->educational_certificate;
            }
            if($request->type == 'academic_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $request->id])->first()->academic_certificate;
            }

            // dd($filename);

            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . Auth::user()->id . DIRECTORY_SEPARATOR . $filename);
            return response()->download($path);

        }else{
            if($request->type == 'birth_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->birth_certificate;
            }
            if($request->type == 'educational_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->educational_certificate;
            }
            if($request->type == 'academic_certificate'){
                $filename = MEPTPApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->academic_certificate;
            }
            // dd($filename);

            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . $filename);
            return response()->download($path);
        }

        // return view('vendor-user.meptp-application-result', compact('application'));
    }
}
