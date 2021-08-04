<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;

class PPMVPendingApplicationController extends Controller
{
    public function applications(Request $request){
        
        $applications = PPMVApplication::select('p_p_m_v_applications.*')
        ->where('payment', true)
        ->where('status', 'send_to_state_office')
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

        return view('stateoffice.ppmv.pending.ppmv-pending-lists', compact('applications'));
    }

    public function show($id){

        $application = PPMVApplication::where('id', $id)
        ->where('payment', true)
        ->where('status', 'send_to_state_office')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('stateoffice.ppmv.pending.ppmv-pending-show', compact('application'));
        }else{
            return abort(404);
        }
    }
}
