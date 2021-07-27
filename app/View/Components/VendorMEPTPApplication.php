<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class VendorMEPTPApplication extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {   
        if(!Auth::user()->hasRole(['vendor'])){
            // do stuff
        }else{
            // $id = Auth::user()->id;

            $application = User::where('id', Auth::user()->id)->with('active_meptp_application', 'user_state', 'user_lga')->first();

            // dd($application);
        }

        return view('components.vendor-m-e-p-t-p-application', compact('application'));
    }
}
