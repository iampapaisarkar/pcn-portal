<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\MEPTPResult;
use App\Models\MEPTPIndexNumber;
use App\Models\Batch;
use App\Models\State;
use App\Models\School;
use DB;

class MEPTPTraningApprovedApplicationsController extends Controller
{
    public function batches(){

        $withoutIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'approved_tier_selected');
            $q->where('index_number_id', null);
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', 'pending');
                $q->where('result', null);
            });
        })
        ->with('meptpApplication.result')
        ->get();

        foreach($withoutIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id == null){
                    $withoutIndexBatches[$key]['index_number_generated'] = false;
                    $withoutIndexBatches[$key]['status'] = 'false';
                }
            }
            $withoutResultBatches[$key]['result_uploaded'] = false;
            $withoutResultBatches[$key]['status'] = 'false';
        }

        $withIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('index_number_id', '!=', null);
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', '!=', 'pending');
                $q->where('result', '!=', null);
            });
        })
        ->with('meptpApplication.result')
        ->get();

        foreach($withIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $withIndexBatches[$key]['index_number_generated'] = true;
                    $withIndexBatches[$key]['status'] = 'true';
                }
            }
            $withIndexBatches[$key]['result_uploaded'] = true;
            $withIndexBatches[$key]['status'] = 'true';
        }

        $batches = (object) array_merge(
            (array) $withoutIndexBatches->toArray(), (array) $withIndexBatches->toArray());

        // dd($batches);

        return view('stateoffice.meptp.trainingapproved.meptp-training-approved-batches', compact('batches'));
    }

    public function centre($batchID){

        $schools = School::where('state', Auth::user()->state)
        ->where('status', true)
        ->get();

        foreach($schools as $key => $school){
            $totalApplication = MEPTPApplication::where('status', 'index_generated')
            ->where('payment', true)
            ->where('batch_id', $batchID)
            ->where('traing_centre', $school->id)
            ->count();

            $schools[$key]['total_application'] =  $totalApplication;
            $schools[$key]['batch_id'] =  $batchID;
        }

        return view('stateoffice.meptp.trainingapproved.meptp-training-approved-centre', compact('schools'));
    }

    public function lists(Request $request){

        if(School::where('state', Auth::user()->state)->where('id', $request->school_id)->exists()){

            $applications = MEPTPApplication::where(['traing_centre' => $request->school_id, 'batch_id' => $request->batch_id])
            ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'indexNumber')
            ->where('payment', true)
            ->where('status', 'index_generated');
            
            if($request->per_page){
                $perPage = (integer) $request->per_page;
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

            return view('stateoffice.meptp.trainingapproved.meptp-training-approved-lists', compact('applications'));
        }else{
            return abort(404);
        }
    }

    // public function show(Request $request){

    //     if(MEPTPApplication::where('id', $request->application_id)
    //     ->where('batch_id', $request->batch_id)
    //     ->where('traing_centre', $request->school_id)
    //     ->where('vendor_id', $request->vendor_id)
    //     ->where('status', 'send_to_state_offcie')
    //     ->where('payment', true)
    //     ->exists()){

    //         $application = MEPTPApplication::where('id', $request->application_id)
    //         ->where('batch_id', $request->batch_id)
    //         ->where('traing_centre', $request->school_id)
    //         ->where('vendor_id', $request->vendor_id)
    //         ->where('status', 'send_to_state_offcie')
    //         ->where('payment', true)
    //         ->first();

    //         return view('stateoffice.meptp.trainingapproved.meptp-training-approved-show', compact('application'));
    //     }else{
    //         return abort(404);
    //     }
    // }
}
