<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use App\Models\State;
use App\Models\Lga;
use App\Models\School;

class BasicInformation
{
    public static function activeBatch(){
        
        $batches = Batch::where(['status' => true]);
        if($batches->exists()){
            $batches = $batches->first();
            return $batches;
        }else{
            return false;
        }
    }

    public static function canSubmitMEPTPApplication(){
        
        $batches = Batch::where(['status' => true]);

        $vendorApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id])
                            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                            ->where('batches.status', '=', false)
                            ->exists();

        if($batches->exists()){
           return true;
        }else{
            return false;
        }
    }

    public static function states()
    {
        $states = State::get();
        return $states;
    }

    public static function lgas()
    {
        $lgas = Lga::get();
        return $lgas;
    }

    public static function schools()
    {
        $authUserState = Auth::user()->user_state;

        $schools = School::where('state', $authUserState->id)->get();
        return $schools;
    }

}