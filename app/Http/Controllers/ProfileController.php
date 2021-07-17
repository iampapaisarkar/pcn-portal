<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Storage;
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

                // Check Image Validation 
                if(request()->file('photo')){
                    $validator = Validator::make($request->all(), [
                        'photo' => 'required|mimes:jpg,png,jpeg'
                    ]);
                    if ($validator->fails()) {
                        return back()->with('error','Supported files is  JPG or PNG or JPEG');
                    }

                    $file = request()->file('photo');
                    $file_name = $file->getClientOriginalName();
                    $file->move('images', $file_name);
                }

                if(isset($file_name) && auth()->user()->photo == $file_name){
                    $fileName = auth()->user()->photo;
                }else if(isset($file_name) && auth()->user()->photo != $file_name){
                    $destinationPath = 'images/';
                    File::delete($destinationPath.auth()->user()->photo);
                    $fileName = $file_name;
                }else if(!isset($file_name) && auth()->user()->photo){
                    $fileName = auth()->user()->photo;
                }else{
                    $fileName = null;
                }

                auth()->user()->update([
                    'address' => $request->address,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'dob' => $request->dob,
                    'photo' => $fileName
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
