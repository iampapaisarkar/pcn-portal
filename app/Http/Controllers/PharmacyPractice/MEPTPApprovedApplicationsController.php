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

class MEPTPApprovedApplicationsController extends Controller
{
    public function batches(){

        $batches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'approved_tier_selected');
            $q->where('payment', true);
        })
        ->with('meptpApplication')
        ->get();

        foreach($batches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $batches[$key]['index_number_generated'] = true;
                }else{
                    $batches[$key]['index_number_generated'] = false;
                }
            }
        }

        return view('pharmacypractice.meptp.approved.meptp-approved-batches', compact('batches'));
    }

    public function states($batchID){

        $states = State::get();

        foreach($states as $key => $state){
            $totalApplication = MEPTPApplication::where('status', 'approved_tier_selected')
            ->where('payment', true)
            ->where('index_number_id', null)
            ->whereHas('user.user_state', function($q) use($state){
                $q->where('states.id', $state->id);
            })
            ->count();

            $states[$key]['total_application'] =  $totalApplication;
        }
        return view('pharmacypractice.meptp.approved.meptp-approved-states', compact('states'));
    }

    public function centre($stateID){

        $schools = School::where('state', $stateID)
        ->where('status', true)
        ->get();

        foreach($schools as $key => $school){
            $totalApplication = MEPTPApplication::where('status', 'approved_tier_selected')
            ->where('payment', true)
            ->where('index_number_id', null)
            // ->where('state', $state->id)
            ->where('traing_centre', $school->id)
            ->count();

            $schools[$key]['total_application'] =  $totalApplication;
        }

        return view('pharmacypractice.meptp.approved.meptp-approved-centre', compact('schools'));
    }

    public function lists(Request $request){

        if(School::where('id', $request->school_id)->exists()){

            $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
            ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
            ->where('index_number_id', null)
            ->where('status', 'approved_tier_selected');
            
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

            return view('pharmacypractice.meptp.approved.meptp-approved-lists', compact('applications'));
        }else{
            return abort(404);
        }
    }

    public function generateIndexNumber(Request $request){

        try {
            DB::beginTransaction();

            $checkboxes = isset($request->check_box_bulk_action) ? true : false;
            if($checkboxes == true){
                foreach($request->check_box_bulk_action as $application_id => $application){
                    $app = MEPTPApplication::where('id', $application_id)
                    ->where('index_number_id', null)
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
                    ->where('status', 'approved_tier_selected')
                    ->first();      
                    
                    $indexNumber = MEPTPIndexNumber::create([
                        'batch_year' => $app->batch->batch_no . '-' . $app->batch->year, 
                        'state_code' => $app->user_state->code ? strtoupper($app->user_state->code) : 'STATE', 
                        'school_code' => $app->school->code ? strtoupper($app->school->code) : 'SCHOOL', 
                        'tier' => strtoupper($app->tier->name[0]) . $app->tier->name[5]
                    ]);

                    MEPTPApplication::where('id', $application_id)
                    ->where('index_number_id', null)
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
                    ->where('status', 'approved_tier_selected')
                    ->update([
                        'status' => 'index_generated',
                        'index_number_id' => $indexNumber->id
                    ]); 
                }

                $response = true;
            }else{
                $response = false;
            }

        DB::commit();

            if($response == true){
                return back()->with('success', 'Index number generated successfully.');
            }else{
                return back()->with('error', 'Please select atleast one apllication.');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
       
    }
}
