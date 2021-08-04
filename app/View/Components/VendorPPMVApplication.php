<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\PPMVApplication;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class VendorPPMVApplication extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $vendor_id;
    public function __construct($applicationID, $vendorID)
    {
        $this->application_id = $applicationID;
        $this->vendor_id = $vendorID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $application = PPMVApplication::where('id', $this->application_id)
        ->where('vendor_id', $this->vendor_id)
        ->where('payment', true)
        // ->where('status', 'send_to_state_office')
        // ->whereHas('user', function($q){
        //     $q->where('state', Auth::user()->state);
        // })
        ->with('user', 'meptp')
        ->first();

        return view('components.vendor-p-p-m-v-application', compact('application'));
    }
}
