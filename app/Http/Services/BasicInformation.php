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
        
        // send_to_state_offcie
        // reject_by_state_offcie
        // send_to_pharmacy_practice
        // reject_by_pharmacy_practice
        // approved_tier_selected
        // index_generated

        $activeBatch = Batch::where('status', true)->first();

        if($activeBatch){
            $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->exists();

            if($isSubmittedApplication){

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'send_to_state_offcie')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'reject_by_state_offcie')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'edit' => true,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'send_to_pharmacy_practice')
               ->exists()){
                     return $response = [
                            'success' => false,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
               ->exists()){
                    return  return $response = [
                            'success' => false,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
                        ];
                }


                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'approved_tier_selected')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'index_generated')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved and Examination Card Generated',
                        ];
                }


            }else{
                $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->exists();

                // $isApplicationRejected = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                // ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                // ->where('m_e_p_t_p_applications.status', '=', 'reject_by_pharmacy_practice')
                // ->exists();

                if($isResultPASS){
                    $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('m_e_p_t_p_results.status', '=', 'pass')
                    ->first();
                    return $response = [
                            'success' => false,
                            'message' => 'YOU ARE LAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$batch->batch_no.'/'.$batch->year.')',
                        ];
                }else{
                    return $response = [
                            'success' => true,
                        ];
                }
            }
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function MEPTPApplicationStatus(){
        $activeBatch = Batch::where('status', true)->first();
        $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->exists();

        if($isSubmittedApplication){
            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'send_to_state_offcie')
           ->exists()){
                return $response = [
                        'color' => 'warning',
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'reject_by_state_offcie')
           ->exists()){
                return $response = [
                        'color' => 'danger',
                        'edit' => true,
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
                        'caption' => 'Document Verification Queried Reason',
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'send_to_pharmacy_practice')
           ->exists()){
                 return $response = [
                        'color' => 'warning',
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
           ->exists()){
                return  return $response = [
                        'color' => 'danger',
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
                        'caption' => 'Document Verification Queried Reason',
                    ];
            }


            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'approved_tier_selected')
           ->exists()){
                return $response = [
                        'color' => 'success',
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved',
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_applications.status', 'index_generated')
           ->exists()){
                return $response = [
                        'color' => 'success',
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved and Examination Card Generated',
                    ];
            }
        }else{
            // $isApplicationRejected = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id])
            //     ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
            //     ->where('m_e_p_t_p_applications.status', '=', 'reject_by_pharmacy_practice')
            //     ->exists();
            return $response = [
                'color' => 'warning',
                'message' => 'No application Found!',
            ];

        }
    }

    public static function MEPTPApplicationResult(){

        // pending
        // pass
        // fail

        $activeBatch = Batch::where('status', true)->first();
        $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->exists();

        if($isSubmittedApplication){

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.appllication_id', 'm_e_p_t_p_applications.id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_results.status', 'pending')
           ->exists()){
                return $response = [
                        'color' => 'warning',
                        'message' => 'MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result Pending',
                        'download_result' => ''
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.appllication_id', 'm_e_p_t_p_applications.id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_results.status', 'fail')
           ->exists()){
                return $response = [
                        'color' => 'danger',
                        'message' => 'Sorry! You were unsuccessful in the MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result Pending',
                        'download_result' => ''
                    ];
            }

            if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
           ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
           ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.appllication_id', 'm_e_p_t_p_applications.id')
           ->where('batches.status', true)
           ->where('m_e_p_t_p_results.status', 'pass')
           ->exists()){
                return $response = [
                        'color' => 'success',
                        'message' => 'Congratulation! You were successful in the MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result Pending',
                        'download_result' => ''
                    ];
            }

           
        }else{
            return $response = [
                'color' => 'warning',
                'message' => 'No results Found!',
            ];

        }
    }

    // public static function canSubmitMEPTPApplication(){
        
    //     // send_to_state_offcie
    //     // reject_by_state_offcie
    //     // send_to_pharmacy_practice
    //     // reject_by_pharmacy_practice
    //     // approved_tier_selected
    //     // index_generated

    //     $activeBatch = Batch::where('status', true)->first();

    //     if($activeBatch){
    //         $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->exists();

    //         if($isSubmittedApplication){

    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'send_to_state_offcie')
    //            ->exists()){
    //                 return $response = [
    //                         'success' => false,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
    //                     ];
    //             }

    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'reject_by_state_offcie')
    //            ->exists()){
    //                 return $response = [
    //                         'success' => false,
    //                         'edit' => true,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
    //                     ];
    //             }

    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'send_to_pharmacy_practice')
    //            ->exists()){
    //                  return $response = [
    //                         'success' => false,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
    //                     ];
    //             }

    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
    //            ->exists()){
    //                 return  return $response = [
    //                         'success' => false,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
    //                     ];
    //             }


    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'approved_tier_selected')
    //            ->exists()){
    //                 return $response = [
    //                         'success' => false,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved',
    //                     ];
    //             }

    //             if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
    //            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
    //            ->where('batches.status', true)
    //            ->where('m_e_p_t_p_applications.status', 'index_generated')
    //            ->exists()){
    //                 return $response = [
    //                         'success' => false,
    //                         'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved and Examination Card Generated',
    //                     ];
    //             }


    //         }else{
    //             $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
    //             ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
    //             ->where('m_e_p_t_p_results.status', '=', 'pass')
    //             ->exists();

    //             // $isApplicationRejected = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
    //             // ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
    //             // ->where('m_e_p_t_p_applications.status', '=', 'reject_by_pharmacy_practice')
    //             // ->exists();

    //             if($isResultPASS){
    //                 return $response = [
    //                         'success' => false,
    //                         'message' => 'YOU ARE LAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
    //                     ];
    //             }else{
    //                 return $response = [
    //                         'success' => true,
    //                     ];
    //             }
    //         }
    //     }else{
    //         return $response = [
    //             'success' => true,
    //         ];
    //     }
    // }

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