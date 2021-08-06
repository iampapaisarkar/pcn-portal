<?php

namespace App\Http\Controllers\Licencing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;

class PPMVLicenceController extends Controller
{
    public function lists(Request $request){
        
        $licences = PPMVRenewal::where('payment', true)
        ->where('status', 'recommended')
        ->with('user', 'ppmv_application', 'meptp_application');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $licences = $licences->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp_application', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $licences = $licences->latest()->paginate($perPage);

        return view('licencing.ppmv-licence-pending-lists', compact('licences'));
    }
}
