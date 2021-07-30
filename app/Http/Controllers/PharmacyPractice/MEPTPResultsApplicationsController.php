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

class MEPTPResultsApplicationsController extends Controller
{
    public function batches(){

        $allBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('index_number_id', '!=', null);
            $q->where('payment', true);
        })
        ->with('meptpApplication.result')
        ->get();

        // dd($allBatches);

        $batches = [];
        foreach($allBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->result && $application->result->status != 'pending'){
                    // $allBatches[$key]['is_result_uploaded'] = true;
                    // $allBatches[$key]['status'] = 'true';

                    $batch['is_result_uploaded'] = true;
                    $batch['status'] = 'true';
                    array_push($batches, $batch);
                }else{
                    // $allBatches[$key]['is_result_uploaded'] = false;
                    // $allBatches[$key]['status'] = 'false';
                    $batch['is_result_uploaded'] = false;
                    $batch['status'] = 'false';
                    array_push($batches, $batch);
                }
            }
        }

        dd($batches);

        return view('pharmacypractice.meptp.results.meptp-results-batches', compact('batches'));
    }

    public function states($batchID, Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            $states = State::get();

            foreach($states as $key => $state){
                $totalApplication = MEPTPApplication::where('payment', true);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $totalApplication = $totalApplication->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
                }
                $totalApplication = $totalApplication->whereHas('user.user_state', function($q) use($state){
                    $q->where('states.id', $state->id);
                })
                ->count();

                $states[$key]['total_application'] =  $totalApplication;
            }
            return view('pharmacypractice.meptp.results.meptp-results-states', compact('states'));
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
                $totalApplication = MEPTPApplication::where('payment', true);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $totalApplication = $totalApplication->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
                }

                $totalApplication = $totalApplication->where('traing_centre', $school->id)
                ->count();

                $schools[$key]['total_application'] =  $totalApplication;
            }

            return view('pharmacypractice.meptp.results.meptp-results-centre', compact('schools'));
        }else{
            return abort(404);
        }
    }

    public function lists(Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            if(School::where('id', $request->school_id)->exists()){

                $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
                ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier');

                if($request->status == 'true'){
                    $applications = $applications->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $applications = $applications->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
                }
                
                if($request->page){
                    $perPage = (integer) $request->page;
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

                return view('pharmacypractice.meptp.results.meptp-results-lists', compact('applications'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }

    }
}
