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

Route::group(['middleware' => ['auth','verified']], function () {
	Route::get('/', function () {
        return view('index');
    })->name('dashboard');

    // Profile routes 
    Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile');
});

Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {
	// Route::get('/', function () {
    //     return view('index');
    // })->name('dashboard');
});