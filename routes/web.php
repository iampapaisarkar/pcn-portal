<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return view('index');
    }else{
        return view('auth.login');
    }
});

Auth::routes(['verify' => true]);


// Profile routes 
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile')->middleware('auth', 'verified');
Route::post('/profile-update', 'App\Http\Controllers\ProfileController@update')->name('profile-update')->middleware('auth', 'verified');
Route::post('/profile-password-update', 'App\Http\Controllers\ProfileController@updatePassword')->name('profile-password-update')->middleware('auth', 'verified');
// Route::post('/remove-photo', 'App\Http\Controllers\ProfileController@removeProfilePhoto')->name('remove-profile-photo')->middleware('auth', 'verified');

Route::group(['middleware' => ['auth','verified', 'CheckProfileStatus']], function () {
	Route::get('/', function () { return view('index'); })->name('dashboard');
});

Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
});