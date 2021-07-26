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
                            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id');
                            
       if($vendorApplication->exists() && $vendorApplication->where('m_e_p_t_p_applications.payment', false)->exists()){
            return $response = [
                'success' => false,
                'message' => 'Application already submited but there have an payment issue. please re-payment from "Invoice" tab.',
            ];
        }if($vendorApplication->exists() && $vendorApplication->where('batches.status', '=', true)->exists()){
            return $response = [
                'success' => false,
                'message' => 'Currently not able to able submit new application. Your previous application still inprogress.',
            ];
        }
        if($vendorApplication->exists() && $vendorApplication->where('m_e_p_t_p_applications.status', '!=', 'approved_card_generated')->exists()){
            return $response = [
                'success' => false,
                'message' => 'Currently not able to able submit new application. Your previous application still inprogress.',
            ];
        }
        if($vendorApplication->exists() && $vendorApplication->where('m_e_p_t_p_applications.status', '!=', 'approved_card_generated')->exists() && $batches->exists()){
            return $response = [
                'success' => false,
                'message' => 'Currently not able to able submit new application. Your previous application still inprogress.',
            ];
        }
        if(!$batches->exists()){
            return $response = [
                'success' => false,
                'message' => 'No active batch found.',
            ];
        }
        
            return $response = [
                'success' => true
            ];
            
        //    if($vendorApplication->exists() && 
        //    $vendorApplication->where('m_e_p_t_p_applications.payment', false)->exists() ||
        //    $vendorApplication->where('batches.status', '=', true)->exists() ||
        //    $vendorApplication->where('m_e_p_t_p_applications.status', '!=', 'approved_card_generated')->exists() ||
        //    ($vendorApplication->where('m_e_p_t_p_applications.status', '!=', 'approved_card_generated')->exists() && $batches->exists()) ||
        //    !$batches->exists()
        //    ){
        //         return $response = [
        //             'success' => false,
        //             'message' => 'No active batch found OR Application already submited.',
        //         ];
        //     }else{
        //         return $response = [
        //             'success' => true
        //         ];
        //     }

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