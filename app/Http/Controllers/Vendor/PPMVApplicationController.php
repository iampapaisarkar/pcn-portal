<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class PPMVApplicationController extends Controller
{
    public function applicationForm(){

        $shop = Auth::user()->passed_meptp_application()->first();

        return view('vendor-user.ppmv.ppmv-application', compact('shop'));
    }
}
