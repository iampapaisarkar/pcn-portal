<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PPMV\PPMVApplicationStoreRequest;
// use App\Http\Requests\PPMV\PPMVApplicationupdateRequest;

class PPMVApplicationController extends Controller
{
    public function applicationForm(){

        $shop = Auth::user()->passed_meptp_application()->first();

        if($shop){
            return view('vendor-user.ppmv.ppmv-application', compact('shop'));
        }else{
            return back();
        }
    }

    public function applicationSubmit(PPMVApplicationStoreRequest $request){
        dd($request->all());
    }
}
