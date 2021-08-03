<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use App\Models\State;
use App\Models\Lga;
use App\Models\School;
use App\Models\MEPTPResult;
use App\Models\Tier;

class BasicInformation
{

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

    public static function tiers()
    {
        $tiers = Tier::get();
        return $tiers;
    }


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

        $activeBatch = Batch::where('status', true)->first();

        if($activeBatch){
            $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->exists();

            if($isSubmittedApplication){

                if(MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->exists()){
                    return $response = [
                        'success' => false,
                        'message' => 'YOU ARE ALREADY PASSED OUT MEPTP TRANING EXAMINATION (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                    ];
                }

                if(MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'fail')
                ->exists()){
                    return $response = [
                        'success' => false,
                        'message' => 'YOU ARE UNSUCCESSFUL IN THE MEPTP TRANING EXAMINATION (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.'). YOU HAVE TO WAIT FOR NEXT BATCH',
                    ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
                ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                ->where('batches.status', true)
                ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
                ->exists()){
                    return $response = [
                        'success' => false,
                        'message' => 'YOUR APPLICATION IS REJECTED (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.'). YOU HAVE TO WAIT FOR NEXT BATCH',
                    ];
                }


                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'send_to_state_offcie')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'reject_by_state_offcie')
               ->exists()){
                    return $response = [
                            'success' => false,
                            // 'edit' => true,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'send_to_pharmacy_practice')
               ->exists()){
                     return $response = [
                            'success' => false,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }


                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'approved_tier_selected')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
               ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
               ->where('batches.status', true)
               ->where('m_e_p_t_p_applications.status', 'index_generated')
               ->exists()){
                    return $response = [
                            'success' => false,
                            'message' => 'CAN\'T SUBMIT NEW APPLICATION. YOUR PREVIOUS APPLICATION IS IN PROGRESS (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.')',
                        ];
                }


            }else{
                $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->exists();

                $isResultPENDING = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '!=', 'pass')
                ->exists();

                if($isResultPASS){
                    $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('m_e_p_t_p_results.status', '=', 'pass')
                    ->with('batch')
                    ->first();
                    return $response = [
                            'success' => false,
                            'message' => 'YOU ARE ALAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                        ];
                }else if($isResultPENDING){
                    $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('m_e_p_t_p_results.status', '!=', 'pass')
                    ->with('batch')
                    ->first();
                    return $response = [
                        'success' => false,
                        'message' => 'YOUR PREVIOUS APPLICATION CURRENTLY INPROGRESS (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                    ];
                }else{
                    return $response = [
                            'success' => true,
                        ];
                }
            }
        }else{
            return $response = [
                'success' => false,
                'message' => 'CURRENTLY NO ACTIVE BATCH FOUND',
            ];
        }
    }

    public static function MEPTPApplicationStatus(){
        $activeBatch = Batch::where('status', true)->first();

        if($activeBatch){

            $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->first();

            if($isSubmittedApplication){
                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
            ->where('batches.status', true)
            ->where('m_e_p_t_p_applications.status', 'send_to_state_offcie')
            ->exists()){
                    return $response = [
                            'color' => 'warning',
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
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
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
                            'edit' => true,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Document Verification Queried',
                            'caption' => $isSubmittedApplication->query,
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
            ->where('batches.status', true)
            ->where('m_e_p_t_p_applications.status', 'send_to_pharmacy_practice')
            ->exists()){
                    return $response = [
                            'color' => 'warning',
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Document Verification Pending',
                        ];
                }

                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
            ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
            ->where('batches.status', true)
            ->where('m_e_p_t_p_applications.status', 'reject_by_pharmacy_practice')
            ->exists()){
                    return $response = [
                            'color' => 'danger',
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: APPLICATION REJECTED',
                            'caption' => $isSubmittedApplication->query,
                        ];
                }


                if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
                ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                ->where('batches.status', true)
                ->where('m_e_p_t_p_applications.status', 'approved_tier_selected')
                ->exists()){
                    return $response = [
                            'color' => 'success',
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
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
                            'is_status' => true,
                            'application_id' => $isSubmittedApplication->id,
                            'vendor_id' => Auth::user()->id,
                            'message' => 'APPLICATION FOR MEPTP (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS: Application Approved and Examination Card Generated',
                            'download_link' => route('meptp-examination-card-download', $isSubmittedApplication->id)
                        ];
                }
            }else{
                $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->exists();

                $isResultPENDING = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '!=', 'pass')
                ->exists();

                if($isResultPASS){
                    $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('m_e_p_t_p_results.status', '=', 'pass')
                    ->with('batch')
                    ->select('m_e_p_t_p_applications.*')
                    ->first();
                    return $response = [
                            'color' => 'warning',
                            'is_status' => true,
                            'application_id' => $batch->id,
                            'vendor_id' => Auth::user()->id,
                            'message' => 'YOU ARE ALAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                        ];
                }else if($isResultPENDING){
                    $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('m_e_p_t_p_results.status', '!=', 'pass')
                    ->with('batch')
                    ->select('m_e_p_t_p_applications.*')
                    ->first();
                    return $response = [
                        'color' => 'warning',
                        'is_status' => true,
                        'application_id' => $batch->id,
                        'vendor_id' => Auth::user()->id,
                        'message' => 'YOUR PREVIOUS APPLICATION CURRENTLY INPROGRESS (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                    ];
                }else{
                    return $response = [
                        'color' => 'warning',
                        'is_status' => false,
                        'message' => 'No application Found!',
                    ];
                }
                
            }
        
        }else{

            $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
            ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
            ->where('m_e_p_t_p_results.status', '=', 'pass')
            ->exists();

            $isResultPENDING = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
            ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
            ->where('m_e_p_t_p_results.status', '!=', 'pass')
            ->exists();

            if($isResultPASS){
                $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->with('batch')
                ->select('m_e_p_t_p_applications.*')
                ->first();
                return $response = [
                        'color' => 'warning',
                        'is_status' => true,
                        'application_id' => $batch->id,
                        'vendor_id' => Auth::user()->id,
                        'message' => 'YOU ARE ALAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                    ];
            }else if(MEPTPApplication::where(['vendor_id' => Auth::user()->id])
                ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                ->where('m_e_p_t_p_applications.status', 'index_generated')
                ->exists()){

                $application = MEPTPApplication::where(['vendor_id' => Auth::user()->id])
                ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                ->where('m_e_p_t_p_applications.status', 'index_generated')
                ->select('m_e_p_t_p_applications.*')
                ->with('batch')
                ->first();


                return $response = [
                        'color' => 'success',
                        'is_status' => true,
                        'application_id' => $application->id,
                        'vendor_id' => Auth::user()->id,
                        'message' => 'APPLICATION FOR MEPTP (Batch: '.$application->batch->batch_no.'/'.$application->batch->year.') STATUS: Application Approved and Examination Card Generated',
                        'download_link' => route('meptp-examination-card-download', $application->id)
                    ];
            }else{
                return $response = [
                    'color' => 'warning',
                    'is_status' => false,
                    'message' => 'No application Found!',
                ];
            }

            // return $response = [
            //     'color' => 'warning',
            //     'is_status' => false,
            //     'message' => 'No application Found!',
            // ];
        }
    }

    public static function MEPTPApplicationResult(){

        $activeBatch = Batch::where('status', true)->first();

        if($activeBatch){

            $isSubmittedApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id, 'batch_id' => $activeBatch->id])->first();

            if($isSubmittedApplication){

                $isResult = MEPTPResult::where(['vendor_id' => Auth::user()->id, 'application_id' => $isSubmittedApplication->id])->exists();

                if($isResult){

                    if(MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id])
                    ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('batches.status', true)
                    ->where('m_e_p_t_p_results.status', 'pending')
                    ->exists()){
                        return $response = [
                                'color' => 'warning',
                                'is_result' => true,
                                'application_id' => $isSubmittedApplication->id,
                                'vendor_id' => Auth::user()->id,
                                'message' => 'MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result Pending',
                            ];
                    }

                    if(MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id])
                ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('batches.status', true)
                ->where('m_e_p_t_p_results.status', 'fail')
                ->exists()){
                        return $response = [
                                'color' => 'danger',
                                'is_result' => true,
                                'application_id' => $isSubmittedApplication->id,
                                'vendor_id' => Auth::user()->id,
                                'message' => 'Sorry! You were unsuccessful in the MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result FAIL',
                            ];
                    }

                    if(MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id])
                    ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')
                    ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                    ->where('batches.status', true)
                    ->where('m_e_p_t_p_results.status', 'pass')
                    ->exists()){
                        return $response = [
                                'color' => 'success',
                                'is_result' => true,
                                'application_id' => $isSubmittedApplication->id,
                                'vendor_id' => Auth::user()->id,
                                'message' => 'Congratulation! You were successful in the MEPTP Training Examination (Batch: '.$activeBatch->batch_no.'/'.$activeBatch->year.') STATUS:  Result PASS',
                                'download_result' => ''
                            ];
                    }

                
                }else{
                    return $response = [
                        'color' => 'warning',
                        'is_result' => false,
                        'message' => 'No results Found!',
                    ];

                }
            }else{
                return $response = [
                    'color' => 'warning',
                    'is_result' => false,
                    'message' => 'No results Found!',
                ];
            }

        }else{

            $isResultPASS = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
            ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
            ->where('m_e_p_t_p_results.status', '=', 'pass')
            ->exists();

            $isResultPENDING = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
            ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
            ->where('m_e_p_t_p_results.status', '!=', 'pass')
            ->exists();

            if($isResultPASS){
                $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '=', 'pass')
                ->with('batch')
                ->select('m_e_p_t_p_applications.*')
                ->first();
                return $response = [
                        'color' => 'warning',
                        'is_result' => true,
                        'application_id' => $batch->id,
                        'vendor_id' => Auth::user()->id,
                        'message' => 'YOU ARE ALAREADY PASSED OUT FOR MEPTP APPLICATION (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                    ];
            }else if($isResultPENDING){
                $batch = MEPTPApplication::where(['m_e_p_t_p_applications.vendor_id' => Auth::user()->id, 'm_e_p_t_p_applications.status' => 'index_generated'])
                ->join('m_e_p_t_p_results', 'm_e_p_t_p_results.application_id', 'm_e_p_t_p_applications.id')
                ->where('m_e_p_t_p_results.status', '!=', 'pass')
                ->with('batch')
                ->select('m_e_p_t_p_applications.*')
                ->first();
                return $response = [
                    'color' => 'warning',
                    'is_result' => true,
                    'application_id' => $batch->id,
                    'vendor_id' => Auth::user()->id,
                    'message' => 'YOUR PREVIOUS APPLICATION CURRENTLY INPROGRESS (Batch: '.$batch->batch->batch_no.'/'.$batch->batch->year.')',
                ];
            }else{
                return $response = [
                    'color' => 'warning',
                    'is_result' => false,
                    'message' => 'No application Found!',
                ];
            }

        }

    }
}