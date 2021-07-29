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
use DB;

class MEPTPApprovedApplicationsController extends Controller
{
    public function batches(){

        $allBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'approved_tier_selected');
            $q->where('payment', true);
        })
        ->with('meptpApplication')
        ->get();

        $batches = [];

        foreach($allBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number){
                    // $allBatches[$key]['index_number_generated'] = true;
                    $batch['index_number_generated'] = true;
                    array_push($batches, $batch);
                }else{
                    $batch['index_number_generated'] = false;
                    array_push($batches, $batch);
                    // $allBatches[$key]['index_number_generated'] = false;
                }
            }
        }

        // dd($batches);

        return view('pharmacypractice.meptp.approved.meptp-approved-batches', compact('batches'));
    }

    public function states($batchID){

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
}
