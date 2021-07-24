<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\FileUpload;
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

            // // Download Method 
            // $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            // DIRECTORY_SEPARATOR . Auth::user()->id . DIRECTORY_SEPARATOR . $filename);

            // return response()->download($path);
            
            // Store MEPTP application 
            MEPTPApplication::create([
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

            DB::commit();

            return back()->with('success','MEPTP Application successfully submited to state office');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function applicationStatus(){

        $application = MEPTPApplication::where('vendor_id', Auth::user()->id)
        ->with('user_state', 'user_lga', 'school', 'batch')
        ->first();
        

        return view('vendor-user.meptp-application-status', compact('application'));
    }
}
