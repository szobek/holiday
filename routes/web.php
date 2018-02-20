<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/hash/{string}', function ($string) {
    return print bcrypt($string);
});

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/loginanother/{id}', 'TestController@loginUseId');

    Route::get('/', function() {
        return redirect('/list/' . date('Y'));
    });
//    Route::get('/', 'TestController@testJson');



    Route::get('/pdf/{year}/{month}/{user_id}/{company_id}', 'AttendanceController@pdf');
    Route::get('/list/{year}', 'UrlController@welcome');
    Route::get('/update/{id}', 'UrlController@modifyEventView');

    Route::post('/update', 'UrlController@modifyEvent');
    Route::post('/create', 'UrlController@createEvent');
    Route::post('/delete', 'UrlController@deleteEvent');


    Route::get('/users', 'UrlController@usersView');
    Route::get('/user/profile/{id}', 'UrlController@usersProfile');
    Route::post('/user/profile', 'UrlController@usersProfileUpdate');
    Route::get('/user/new', 'UrlController@usersNewView');
    Route::get('/user/delete/{id}', 'UrlController@userDelete');
    Route::post('/user/new', 'UrlController@usersNew');

    Route::get('/companies', 'UrlController@listCompaniesView');
    Route::get('/companies/profile/{id}', 'UrlController@companyProfile');
    Route::post('/companies/profile', 'UrlController@companySave');
    Route::get('/companies/new', 'UrlController@companyNewView');
    Route::post('/companies/new', 'UrlController@companyNew');


    Route::get('/nonworking/update/{id}', 'NonWorkingController@nonWorkingDetailView');
    Route::post('/nonworking/update/{id}', 'NonWorkingController@nonWorkingDetail');
    Route::get('/nonworking/create', 'NonWorkingController@nonWorkingCreateView');
    Route::post('/nonworking/create', 'NonWorkingController@nonWorkingCreate');
    Route::get('/nonworking/{year?}', 'UrlController@nonWorkingView');


    Route::get('/permissions', 'PermissionController@listPermissionsView');
    Route::get('/permissions/contact_user/add/{user_id}/{permission_id}', 'PermissionController@addPermissionToUser');
    Route::get('/permissions/contact_user/delete/{user_id}/{permission_id}', 'PermissionController@deletePermissionFromUser');
    Route::get('/permissions/contact_user/{id}', 'PermissionController@contactUserToPermissionView');
    Route::get('/permissions/{id}', 'PermissionController@editPermissionView');
    Route::post('/permissions/{id}', 'PermissionController@editPermission');


    Route::get('testMail', 'UrlController@testMail');
//    Route::get('/csv', 'UrlController@csvTest');




});


Route::get('/ck', function () {
    return view('test');
});




