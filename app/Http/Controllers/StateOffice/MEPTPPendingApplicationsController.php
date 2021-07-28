<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use App\Models\School;


class MEPTPPendingApplicationsController extends Controller
{
    public function batches(){

        $batches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'send_to_state_offcie');
            $q->where('payment', true);
        })
        ->get();

        return view('stateoffice.meptp.meptp-pending-batches', compact('batches'));
    }

    public function centre($batchID){

        // $batches = Batch::whereHas('meptpApplication', function($q){
        //     $q->where('status', 'send_to_state_offcie');
        //     $q->where('payment', true);
        // })
        // ->get();

        $schools = School::where('state', Auth::user()->state)
        ->get();

        foreach($schools as $key => $school){
            $totalApplication = MEPTPApplication::where('status', 'send_to_state_offcie')
            ->where('payment', true)
            ->where('batch_id', $batchID)
            ->where('traing_centre', $school->id)
            ->count();

            $schools[$key]['total_application'] =  $totalApplication;
        }

        // dd($schools);

        return view('stateoffice.meptp.meptp-pending-centre', compact('schools'));
    }
}
