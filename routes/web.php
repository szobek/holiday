<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/', function() {
        return redirect('/list/' . date('Y'));
    });
    Route::get('/pdf/{company}/{year}/{month}', 'UrlController@pdf');
    Route::get('/pdf/{company}/{year}/{month}/{user_id}', 'UrlController@pdf');
    Route::get('/list/{year}', 'UrlController@welcome');
    Route::get('/update/{id}', 'UrlController@modifyEventView');

    Route::post('/update', 'UrlController@modifyEvent');
    Route::post('/create', 'UrlController@createEvent');
    Route::post('/delete', 'UrlController@deleteEvent');


    Route::get('/users', 'UrlController@usersView');
    Route::get('/user/profile/{id}', 'UrlController@usersProfile');
    Route::post('/user/profile', 'UrlController@usersProfileUpdate');
    Route::get('/user/new', 'UrlController@usersNewView');
    Route::post('/user/new', 'UrlController@usersNew');

    Route::get('/companies', 'UrlController@listCompaniesView');
    Route::get('/companies/profile/{id}', 'UrlController@companyProfile');
    Route::post('/companies/profile', 'UrlController@companySave');
    Route::get('/companies/new', 'UrlController@companyNewView');
    Route::post('/companies/new', 'UrlController@companyNew');

    Route::get('/nonworking/{year?}', 'UrlController@nonWorkingView');
    Route::get('testMail', 'UrlController@testMail');


});



