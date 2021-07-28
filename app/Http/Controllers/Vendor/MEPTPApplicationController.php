<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\FileUpload;
use App\Http\Services\Checkout;
use App\Http\Requests\MEPTP\MEPTPApplicationRequest;
use App\Http\Requests\MEPTP\MEPTPApplicationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use DB;
use File;
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
                'status' => 'send_to_state_offcie',
            ]);

            $response = Checkout::checkoutMEPTP($application = ['id' => $application->id]);

            DB::commit();

                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Application successfully submitted. Please pay amount for further action');

        }catch(Exception $e) {
        DB::rollback();
        return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function applicationEdit(){
        $application = MEPTPApplication::where(['vendor_id' => Auth::user()->id])
        ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
        ->where('batches.status', true)
        ->where('m_e_p_t_p_applications.status', 'reject_by_state_offcie')
        ->with('user_state', 'user_lga', 'school', 'batch', 'user.user_state', 'user.user_lga')
        ->first();

        if($application){
            return view('vendor-user.meptp-appication-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function applicationUpdate(MEPTPApplicationUpdateRequest $request, $application_id){
        try {
            DB::beginTransaction();

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $application_id])->exists()){

                $application = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $application_id])->first();

                if($request->file('birth_certificate') != null){
                    if($application->birth_certificate == $request->file('birth_certificate')->getClientOriginalName()){
                        $birth_certificate = $application->birth_certificate;
                    }else{
                        $birth_certificate = FileUpload::upload($request->file('birth_certificate'), $private = true);
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . $application->birth_certificate);
                        File::Delete($path);
                    }
                }else{
                    $birth_certificate = $application->birth_certificate;
                }

                if($request->file('educational_certificate') != null){
                    if($application->educational_certificate == $request->file('educational_certificate')->getClientOriginalName()){
                        $educational_certificate = $application->educational_certificate;
                    }else{
                        $educational_certificate = FileUpload::upload($request->file('educational_certificate'), $private = true);
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . $application->educational_certificate);
                        File::Delete($path);
                    }
                }else{
                    $educational_certificate = $application->educational_certificate;
                }
                
                if($request->file('academic_certificate') != null){
                    if($application->academic_certificate == $request->file('academic_certificate')->getClientOriginalName()){
                        $academic_certificate = $application->academic_certificate;
                    }else{
                        $academic_certificate = FileUpload::upload($request->file('academic_certificate'), $private = true);
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . $application->academic_certificate);
                        File::Delete($path);
                    }
                }else{
                    $academic_certificate = $application->academic_certificate;
                }
                

                MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'id' => $application_id])
                ->update([
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
                    'status' => 'send_to_state_offcie',
                ]);

                $response = true;
               
            }else{
                $response = false;
            }

            DB::commit();

                if($response == true){
                    return redirect()->route('meptp-application-status')
                    ->with('success', 'Application successfully updated');
                }else{
                    return back()->with('error','There is something error, please try after some time');
                }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function applicationStatus(){

        return view('vendor-user.meptp-application-status');
    }

    public function applicationResult(){

        return view('vendor-user.meptp-application-result');
    }

    public function downloadMEPTPDocument(Request $request){

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

            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . $filename);
            return response()->download($path);
        }

    }
}
