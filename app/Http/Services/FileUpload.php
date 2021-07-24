<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use File;
use Storage;
use Session;
use DB;
use URL;

class FileUpload
{
    private $image_allowed_mimes = ['image/bmp', 'image/gif', 'image/jpeg', 'image/tiff', 'image/png'];

    public static function upload($file, $private = false){

        if($private === true){
            $private_storage_path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . Auth::user()->id);
            if(!file_exists($private_storage_path)){
                \mkdir($private_storage_path, intval('755',8), true);
            }

            $file_name = $file->getClientOriginalName();
            $file->move($private_storage_path, $file_name);

            return $file_name;
        }else{
            $default_storage_path = storage_path('app'. DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR . 'images');
            if(!file_exists($default_storage_path)){
                mkdir($default_storage_path, intval('755',8), true);
            }
            $file_name = $file->getClientOriginalName();
            $file->move($private_storage_path, $file_name);
            return $file_name;
        }
    }


}