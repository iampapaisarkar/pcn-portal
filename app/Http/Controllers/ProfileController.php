<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function update(Request $requet){

        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['vendor'])){
                
            }

            DB::commit();

            return back()->with('success','Your query successfully submitted');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  

    }
}
