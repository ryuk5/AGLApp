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

//Pages Routing
Route::get('/', 'PagesController@index')->name('index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Giver')->prefix('giver')->name('giver.')->group(function(){
    //Routes for donations
    Route::get('/donations/subject_choice', 'DonationsController@subject_choice')->name('donations.subject_choice');
    Route::match(['get', 'post'], '/donations/create', 'DonationsController@create')->name('donations.create');
    Route::resource('/donations', 'DonationsController', ['except' => ['create']]);
});

Route::namespace('Applicant')->prefix('applicant')->name('applicant.')->group(function(){
    
    //Routes for demands
    Route::get('/demands/subject_choice', 'DemandsController@subject_choice')->name('demands.subject_choice');
    Route::match(['get', 'post'], '/demands/create', 'DemandsController@create')->name('demands.create');
    Route::resource('/demands', 'DemandsController', ['except' => ['create']]);
    
    //Routes for Reservations
    Route::post('/reservations', 'ReservationsController@store')->name('reservations.store');
    Route::resource('/reservations', 'ReservationsController', ['except' => ['store', 'create', 'edit']]);
    
});

Route::namespace('Contact')->prefix('contact')->name('contact.')->group(function(){
    //Routes for Contacts
    Route::put('/delivery/handleChaking/{delivery}', 'DeliveriesController@handleChaking')->name('delivery.handleChaking');
    Route::resource('/delivery', 'DeliveriesController');

    //Routes for delivery man delivery-man
    Route::resource('/delivery-man', 'DeliveryManController', ['except' => ['store', 'update', 'destroy']]);
});


//Routes for Admins
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});

