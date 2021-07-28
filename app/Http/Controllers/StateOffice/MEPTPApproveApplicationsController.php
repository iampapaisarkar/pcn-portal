<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use App\Models\School;

class MEPTPApproveApplicationsController extends Controller
{
    public function batches(){

        $batches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'send_to_pharmacy_practice');
            $q->where('payment', true);
        })
        ->get();

        return view('stateoffice.meptp.approve.meptp-approve-batches', compact('batches'));
    }
}
