<?php

namespace App\Http\Controllers\PharmacyPractice;

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
use App\Http\Services\AllActivity;
use App\Exports\ResultTemplateExport;
use Excel;

class MEPTPResultsApplicationsController extends Controller
{
    public function batches(){

        $withoutResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', 'pending');
                $q->where('result', null);
            });
        })
        ->with('meptpApplication.result')
        ->get();

        foreach($withoutResultBatches as $key => $batch){
            $withoutResultBatches[$key]['result_uploaded'] = false;
            $withoutResultBatches[$key]['status'] = 'false';
        }

        $withResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', '!=', 'pending');
                $q->where('result', '!=', null);
            });
        })
        ->with('meptpApplication.result')
        ->get();

        foreach($withResultBatches as $key => $batch){
            $withResultBatches[$key]['result_uploaded'] = true;
            $withResultBatches[$key]['status'] = 'true';
        }

        $batches = (object) array_merge(
            (array) $withoutResultBatches->toArray(), (array) $withResultBatches->toArray());


        // $batches = Batch::whereHas('meptpApplication', function($q){
        //     $q->where('status', 'index_generated');
        //     $q->where('payment', true);
        // })
        // ->with('meptpApplication.result')
        // ->paginate(20);


        // dd($batches);

        return view('pharmacypractice.meptp.results.meptp-results-batches', compact('batches'));
    }

    public function states($batchID, Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            $states = State::get();

            foreach($states as $key => $state){
                $totalApplication = MEPTPApplication::where('payment', true)->where('status', 'index_generated')
                ->where('batch_id', $batchID);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('result', '!=', null);
                    });
                }else{
                    $totalApplication = $totalApplication->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('result', null);
                    });
                }
                $totalApplication = $totalApplication->whereHas('user.user_state', function($q) use($state){
                    $q->where('states.id', $state->id);
                })
                ->count();

                $states[$key]['total_application'] =  $totalApplication;
            }
            return view('pharmacypractice.meptp.results.meptp-results-states', compact('states', 'batchID'));
        }else{
            return abort(404);
        }

    }

    public function centre($stateID, Request $request){
        if($request->status == 'false' || $request->status == 'true'){

            $schools = School::where('state', $stateID)
            ->where('status', true)
            ->get();

            foreach($schools as $key => $school){
                $totalApplication = MEPTPApplication::where('payment', true)->where('status', 'index_generated')
                ->where('batch_id', $request->batch_id);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('result', '!=', null);
                    });
                }else{
                    $totalApplication = $totalApplication->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('result', null);
                    });
                }

                $totalApplication = $totalApplication->where('traing_centre', $school->id)
                ->count();

                $schools[$key]['total_application'] =  $totalApplication;
            }

            $batchID = $request->batch_id;

            return view('pharmacypractice.meptp.results.meptp-results-centre', compact('schools', 'batchID'));
        }else{
            return abort(404);
        }
    }

    public function lists(Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            if(School::where('id', $request->school_id)->exists()){

                $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
                ->where('status', 'index_generated')
                ->where('batch_id', $request->batch_id)
                ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier', 'indexNumber');

                if($request->status == 'true'){
                    $applications = $applications->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('result', '!=', null);
                    });
                }else{
                    $applications = $applications->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('result', null);
                    });
                }
                
                if($request->per_page){
                    $perPage = (integer) $request->per_page;
                }else{
                    $perPage = 10;
                }
        
                if(!empty($request->search)){
                    $search = $request->search;
                    $applications = $applications->where(function($q) use ($search){
                        $q->where('m_e_p_t_p_applications.shop_name', 'like', '%' .$search. '%');
                        $q->orWhere('m_e_p_t_p_applications.shop_address', 'like', '%' .$search. '%');
                    });
                }
        
                $applications = $applications->latest()->paginate($perPage);

                $schoolID = $request->school_id;
                $batchID = $request->batch_id;

                return view('pharmacypractice.meptp.results.meptp-results-lists', compact('applications', 'schoolID', 'batchID'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }

    }

    public function downloadResultTemplate(Request $request){
        // dd($request->all());

        $data = MEPTPApplication::where(['batch_id'=>$request->batch_id, 'traing_centre'=>$request->school_id])
        ->where('status', 'index_generated')
        ->with('indexNumber', 'user', 'tier', 'batch', 'school')->get();
        // dd($data);
        $array = array();
        foreach ($data as $key => $value) {
            $fields = [
                'S/N' => $key+1, 
                'vendor_id' => $value['vendor_id'], 
                'application_id' => $value['id'], 
                'name_of_candidate' => $value['user']['firstname'] .' '.$value['user']['lastname'],
                'index_numbers' => $value['indexNumber']['arbitrary_1'] .'/'. $value['indexNumber']['arbitrary_2'] .'/'. $value['indexNumber']['batch_year'] .'/'. $value['indexNumber']['state_code'] .'/'. $value['indexNumber']['school_code'] .'/'. $value['indexNumber']['tier'] .'/'. $value['indexNumber']['id'],
                'tier' => $value['tier']['name'], 
                'batch' => $value['batch']['batch_no'].'/'.$value['batch']['year'], 
                'traning_centre' => $value['school']['name'], 
                'exam_score' => '', 
                'percentage_score' => '', 
            ];
            array_push($array, $fields);
        }

        $results = new ResultTemplateExport($array);

        return Excel::download($results, 'result-template.xlsx');
    }

    public function uploadResult(Request $request){
        dd($request->all());
    }

    // $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
    // $activity = 'MEPTP Examination Result Uploaded';
    // AllActivity::storeActivity($app->id, $adminName, $activity, 'meptp');
}
