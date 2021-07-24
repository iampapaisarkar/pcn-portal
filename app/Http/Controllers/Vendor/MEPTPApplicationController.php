<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MEPTP\MEPTPApplicationRequest;

class MEPTPApplicationController extends Controller
{
    public function applicationSubmit(MEPTPApplicationRequest $request){
        dd($request->all());
    }
}
