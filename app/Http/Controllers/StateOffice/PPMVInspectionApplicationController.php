<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;

class PPMVInspectionApplicationController extends Controller
{
    public function applications(Request $request){
        
        $applications = PPMVApplication::select('p_p_m_v_applications.*')
        ->where('payment', true)
        ->where('status', 'approved')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $applications = $applications->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $applications = $applications->latest()->paginate($perPage);

        return view('stateoffice.ppmv.inspection.ppmv-inspection-lists', compact('applications'));
    }

    public function show($id){

        $application = PPMVApplication::where('id', $id)
        ->where('payment', true)
        ->where('status', 'approved')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('stateoffice.ppmv.inspection.ppmv-inspection-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function submitInspectionReport(Request $request, $id){
        $this->validate($request, [
            'recommendation' => ['required'],
            'inspection_report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $application = PPMVApplication::where('id', $id)->where('status', 'approved')->first();

            if($application){

                $file = $request->file('inspection_report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $application->vendor_id . DIRECTORY_SEPARATOR . 'PPMV'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'vendor'.$application->vendor_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                PPMVApplication::where('id', $id)
                ->where('status', 'approved')
                ->where('payment', true)
                ->update([
                    'status' => $request->recommendation,
                    'query' => $request['query'],
                ]);

                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                $activity = 'State Officer Document Verification Query';
                AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');
            }
            
            DB::commit();

            return redirect()->route('ppmv-inspection-applications')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
