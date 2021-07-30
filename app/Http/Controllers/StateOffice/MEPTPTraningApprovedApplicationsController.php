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
        })
        ->with('meptpApplication')
        ->get();

        foreach($withoutIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id == null){
                    $withoutIndexBatches[$key]['index_number_generated'] = false;
                    $withoutIndexBatches[$key]['status'] = 'false';
                }
            }
        }

        $withIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('index_number_id', '!=', null);
            $q->where('payment', true);
        })
        ->with('meptpApplication')
        ->get();

        foreach($withIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $withIndexBatches[$key]['index_number_generated'] = true;
                    $withIndexBatches[$key]['status'] = 'true';
                }
            }
        }

        $batches = (object) array_merge(
            (array) $withoutIndexBatches->toArray(), (array) $withIndexBatches->toArray());

        // dd($batches);

        return view('stateoffice.meptp.trainingapproved.meptp-training-approved-batches', compact('batches'));
    }
}
