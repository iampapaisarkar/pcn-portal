<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Http\Services\AllActivity;

class PPMVPendingApplicationController extends Controller
{
    public function applications(Request $request){
        
        $applications = PPMVApplication::select('p_p_m_v_applications.*')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where('p_p_m_v_renewals.renewal_year', date('Y'))
        ->where('p_p_m_v_renewals.payment', true)
        ->where('p_p_m_v_renewals.status', 'pending')
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

        return view('stateoffice.ppmv.pending.ppmv-pending-lists', compact('applications'));
    }

    public function show($id){

        $application = PPMVApplication::select('p_p_m_v_applications.*')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where('p_p_m_v_renewals.renewal_year', date('Y'))
        ->where('p_p_m_v_renewals.payment', true)
        ->where('p_p_m_v_renewals.status', 'pending')
        ->where('p_p_m_v_applications.id', $id)
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('stateoffice.ppmv.pending.ppmv-pending-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function downloadDocument(Request $request){
        if($request->type == 'reference_1_letter'){
            $filename = PPMVApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->reference_1_letter;
        }
        if($request->type == 'reference_2_letter'){
            $filename = PPMVApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->reference_2_letter;
        }

        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV' . DIRECTORY_SEPARATOR . $filename);
        return response()->download($path);
    }

    public function approve(Request $request){

        // if(PPMVApplication::where('id', $request->application_id)
        // ->where('vendor_id', $request->vendor_id)
        // ->where('status', 'send_to_state_office')
        // ->where('payment', true)
        // ->exists()){

        //     $application = PPMVApplication::where('id', $request->application_id)
        //     ->where('vendor_id', $request->vendor_id)
        //     ->where('status', 'send_to_state_office')
        //     ->where('payment', true)
        //     ->update([
        //         'status' => 'approved',
        //         'query' => null,
        //         'token' => random_bytes(6),
        //     ]);

        //     $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
        //     $activity = 'State Officer Document Verification Approved';
        //     AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

        //     return redirect()->route('meptp-pending-batches')->with('success', 'Application Approved successfully done');
        // }else{
        //     return abort(404);
        // }

        if(PPMVRenewal::where('ppmv_application_id', $request->application_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('payment', true)
        ->where('status', 'pending')
        ->where('renewal_year', date('Y'))
        ->exists()){

            $application = PPMVRenewal::where('ppmv_application_id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->where('status', 'pending')
            ->where('renewal_year', date('Y'))
            ->update([
                'status' => 'approved',
                'query' => null,
                'token' => random_bytes(6),
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approved';
            AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

            return redirect()->route('meptp-pending-batches')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function query(Request $request){
       
        $this->validate($request, [
            'query' => ['required'],
        ]);

        if(PPMVRenewal::where('ppmv_application_id', $request->application_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('payment', true)
        ->where('status', 'pending')
        ->where('renewal_year', date('Y'))
        ->exists()){

            $application = PPMVRenewal::where('ppmv_application_id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->where('status', 'pending')
            ->where('renewal_year', date('Y'))
            ->update([
                'status' => 'rejected',
                'query' => $request['query'],
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Query';
            AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

            return redirect()->route('meptp-pending-batches')->with('success', 'Application Quired successfully');
        }else{
            return abort(404);
        }

        // if(PPMVApplication::where('id', $request->application_id)
        // ->where('vendor_id', $request->vendor_id)
        // ->where('status', 'send_to_state_office')
        // ->where('payment', true)
        // ->exists()){
        //     $application = PPMVApplication::where('id', $request->application_id)
        //     ->where('vendor_id', $request->vendor_id)
        //     ->where('status', 'send_to_state_office')
        //     ->where('payment', true)
        //     ->update([
        //         'status' => 'rejected',
        //         'query' => $request['query'],
        //     ]);

        //     $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
        //     $activity = 'State Officer Document Verification Query';
        //     AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

        //     return redirect()->route('meptp-pending-batches')->with('success', 'Application Quired successfully');
        // }else{
        //     return back()->with('error', 'There is something error, please try after some time');
        // }
    }
}
