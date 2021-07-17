<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use DB;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function update(Request $request){

        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['vendor'])){

                $this->validate($request, [
                    'address' => [
                        'required', 'min:3', 'max:255'
                    ],
                    'state' => [
                        'required'
                    ],
                    'lga' => [
                        'required'
                    ],
                    'dob' => [
                        'required'
                    ]
                ]);

                $authUser = Auth::user();

                auth()->user()->update([
                    'address' => $request->address,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'dob' => $request->dob
                ]);
            }

            DB::commit();

            return back()->with('success','Profile updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  

    }
}
