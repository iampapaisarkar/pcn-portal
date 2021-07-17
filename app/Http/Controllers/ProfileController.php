<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function update(Request $requet){
        // return back()->with('success','Your query successfully submitted');
        return back()->with('error','There is something error, please try after some time');

        dd($requet->all());
        return view('profile');
    }
}
