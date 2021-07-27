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
Route::get('/active-account', 'App\Http\Controllers\ProfileController@activeAccount')->name('active-account');
Route::post('/activision-account', 'App\Http\Controllers\ProfileController@activisionAccount')->name('activision-account');

Auth::routes(['verify' => true]);


// Profile routes 
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile')->middleware('auth', 'verified');
Route::post('/profile-update', 'App\Http\Controllers\ProfileController@update')->name('profile-update')->middleware('auth', 'verified');
Route::post('/profile-password-update', 'App\Http\Controllers\ProfileController@updatePassword')->name('profile-password-update')->middleware('auth', 'verified');
// Route::post('/remove-photo', 'App\Http\Controllers\ProfileController@removeProfilePhoto')->name('remove-profile-photo')->middleware('auth', 'verified');

Route::group(['middleware' => ['auth','verified', 'CheckProfileStatus']], function () {
    Route::get('/', function () { return view('index'); })->name('dashboard');

    Route::get('/download-meptp-application-document', 'App\Http\Controllers\Vendor\MEPTPApplicationController@downloadMEPTPDocument')->name('download-meptp-application-document');
});

Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    Route::resource('schools', 'App\Http\Controllers\Admin\SchoolController');
    Route::resource('batches', 'App\Http\Controllers\Admin\BatchController');
    Route::resource('services', 'App\Http\Controllers\Admin\Service\ServiceController');
    Route::resource('services-fee', 'App\Http\Controllers\Admin\Service\ServiceFeeController');

    Route::get('/payments', 'App\Http\Controllers\InvoiceController@index')->name('payments.index');
	Route::get('/payments/{id}', 'App\Http\Controllers\InvoiceController@show')->name('payments.show');
});

Route::group(['middleware' => ['auth','verified', 'can:isVendor', 'CheckProfileStatus']], function () {

    // Route::resource('services-fee', 'App\Http\Controllers\Admin\Service\ServiceFeeController');

	Route::get('/meptp-application', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationForm')->name('meptp-application');
    Route::post('/meptp-application-submit', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationSubmit')->name('meptp-application-submit');
    Route::get('/meptp-application-status', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationStatus')->name('meptp-application-status');
    Route::get('/meptp-application-result', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationResult')->name('meptp-application-result');

    // Checkout 
    Route::get('/checkout-meptp/{token}', 'App\Http\Controllers\Vendor\CheckoutController@checkoutMEPTP')->name('checkout-meptp');
    Route::get('/payment-failed/{token}', 'App\Http\Controllers\Vendor\CheckoutController@paymentError')->name('payment-failed');
    Route::get('/payment-success/{token}', 'App\Http\Controllers\Vendor\CheckoutController@paymentSuccess')->name('payment-success');
	Route::get('/invoices', 'App\Http\Controllers\InvoiceController@index')->name('invoices.index');
	Route::get('/invoices/{id}', 'App\Http\Controllers\InvoiceController@show')->name('invoices.show');
});