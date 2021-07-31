<?php

namespace App\Http\Controllers\PharmacyPractice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\MEPTPResult;
use App\Models\Batch;
use App\Models\State;
use App\Models\School;
use App\Models\Tier;
use DB;
use App\Http\Services\AllActivity;

class MEPTPApprovalApplicationsController extends Controller
{

    public function states(){

        $states = State::get();

        foreach($states as $key => $state){
            $totalApplication = MEPTPApplication::where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            // ->where('state', $state->id)
            ->whereHas('user.user_state', function($q) use($state){
                $q->where('states.id', $state->id);
            })
            ->count();

            $states[$key]['total_application'] =  $totalApplication;
        }
        return view('pharmacypractice.meptp.approval.meptp-approval-states', compact('states'));
    }

    public function centre($stateID){

        $schools = School::where('state', $stateID)
        ->where('status', true)
        ->get();

        foreach($schools as $key => $school){
            $totalApplication = MEPTPApplication::where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            // ->where('state', $state->id)
            ->where('traing_centre', $school->id)
            ->count();

            $schools[$key]['total_application'] =  $totalApplication;
        }

        return view('pharmacypractice.meptp.approval.meptp-approval-centre', compact('schools'));
    }

    public function lists(Request $request){

        if(School::where('id', $request->school_id)->exists()){

            $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
            ->with('user_state', 'user_lga', 'school', 'batch', 'user')
            ->where('status', 'send_to_pharmacy_practice');
            
            if($request->page){
                $perPage = (integer) $request->page;
            }else{
                $perPage = 10;
            }
    
            if(!empty($request->search)){
                $search = $request->search;
                $applications = $applications->where(function($q) use ($search){
                    $q->where('m_e_p_t_p_applications.shop_name', 'like', '%' .$search. '%');
                    $q->orWhere('m_e_p_t_p_applications.shop_address', 'like', '%' .$search. '%');
                });
            }
    
            $applications = $applications->latest()->paginate($perPage);

            return view('pharmacypractice.meptp.approval.meptp-approval-lists', compact('applications'));
        }else{
            return abort(404);
        }
    }

    public function show(Request $request){

        if(MEPTPApplication::where('id', $request->application_id)
        ->where('traing_centre', $request->school_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('status', 'send_to_pharmacy_practice')
        ->where('payment', true)
        ->exists()){

            $application = MEPTPApplication::where('id', $request->application_id)
            ->where('traing_centre', $request->school_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            ->first();

            return view('pharmacypractice.meptp.approval.meptp-approval-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function selectForTier(Request $request){
        $this->validate($request, [
            'tier' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            if(MEPTPApplication::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            ->exists()){
                $application = MEPTPApplication::where('id', $request->application_id)
                ->where('vendor_id', $request->vendor_id)
                ->where('status', 'send_to_pharmacy_practice')
                ->where('payment', true)
                ->update([
                    'status' => 'approved_tier_selected',
                    'tier_id' => $request['tier'],
                ]);

                MEPTPResult::create([
                    'application_id' => $request->application_id,
                    'vendor_id' => $request->vendor_id,
                    'status' => 'pending',
                ]);

                $tier = Tier::where('id', $request['tier'])->first();
                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                $activity = 'Pharmacy Practice Approval and Tiering ' . $tier->name;
                AllActivity::storeActivity($request->application_id, $adminName, $activity, 'meptp');

                $response = true;
            }else{
                $response = false;
            }

            DB::commit();

            if($response == true){
                return redirect()->route('meptp-approval-states')->with('success', 'Application successfully approved & tier seleted');
            }else{
                return back()->with('error', 'There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function query(Request $request){
        $this->validate($request, [
            'query' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            if(MEPTPApplication::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            ->exists()){
                $application = MEPTPApplication::where('id', $request->application_id)
                ->where('vendor_id', $request->vendor_id)
                ->where('status', 'send_to_pharmacy_practice')
                ->where('payment', true)
                ->update([
                    'status' => 'reject_by_pharmacy_practice',
                    'query' => $request['query'],
                ]);

                // MEPTPResult::create([
                //     'application_id' => $request->application_id,
                //     'vendor_id' => $request->vendor_id,
                //     'status' => 'pending',
                // ]);

                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                $activity = 'Pharmacy Practice Document Verification Query';
                AllActivity::storeActivity($request->application_id, $adminName, $activity, 'meptp');

                $response = true;
            }else{
                $response = false;
            }
            DB::commit();

            if($response == true){
                return redirect()->route('meptp-approval-states')->with('success', 'Application successfully quired & rejected');
            }else{
                return back()->with('error', 'There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
