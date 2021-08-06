<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;


class PPMVInspectionReportController extends Controller
{
    public function reports(Request $request){
        
        $applications = PPMVApplication::select('p_p_m_v_applications.*', 'p_p_m_v_renewals.status', 'p_p_m_v_renewals.token')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where(function($q){
            $q->where('p_p_m_v_renewals.status', 'recommended');
            $q->orWhere('p_p_m_v_renewals.status', 'unrecommended');
        })
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $applications = $applications->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $applications = $applications->latest()->paginate($perPage);

        return view('stateoffice.ppmv.report.ppmv-inspection-reports', compact('applications'));
    }


    public function show($id){

        $application = PPMVApplication::select('p_p_m_v_applications.*', 'p_p_m_v_renewals.status', 'p_p_m_v_renewals.token')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where(function($q){
            $q->where('p_p_m_v_renewals.status', 'recommended');
            $q->orWhere('p_p_m_v_renewals.status', 'unrecommended');
        })
        ->where('p_p_m_v_applications.id', $id)
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('stateoffice.ppmv.report.ppmv-inspection-report-show', compact('application'));
        }else{
            return abort(404);
        }
    }
}
