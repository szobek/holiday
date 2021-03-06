<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/test', function() {



});

Route::get('/hash/{string}', function ($string) {
    return print bcrypt($string);
});

Route::get('/search', 'TestController@search');


Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect('/list/' . date('Y'));
    });


    Route::get('/pdf/{year}/{month}/{user_id}/{company_id}', 'AttendanceController@pdf');
    Route::get('/list/{year}', 'UrlController@welcome');
    Route::get('/event/update/{id}', 'UrlController@modifyEventView');

    Route::post('/event/update', 'UrlController@modifyEvent');
    Route::get('/event/view/{id}', 'UrlController@viewEvent');
    Route::post('/create', 'UrlController@createEvent');
    Route::post('/event/delete', 'UrlController@deleteEvent');
    Route::get('/event/search', 'UrlController@searchEventView');
    Route::post('/event/search', 'UrlController@searchEvent');


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


    Route::get('backup', 'CalendarController@backupGoogleEvents');


//    Route::resource('workhours', 'WorkhoursController');
    Route::get('workhours', 'checkinController@listAll');
    Route::get('workhours/edit/{id}', 'checkinController@updateView');

    Route::get('workhours/new', 'checkinController@createByAdminView');
    Route::post('workhours/new', 'checkinController@createByAdmin');

    Route::post('workhours/edit/{id}', 'checkinController@updateWorkhour');
    Route::get('workhours/delete/{id}', 'checkinController@deleteWorkhour');

    Route::get('workhours/single-user/{id}', 'checkinController@getSingleUserInteractions');
    Route::get('workhours/single-day/{start}', 'checkinController@getSingleDayInteractions');
    Route::get('workhours/date-range/{start}/{end}', 'checkinController@getDateRangeInteractions');


//    ajax url's
    Route::get('/api/messages/all','MessageController@apiGetConversations');
    Route::get('/api/message/{id}','MessageController@getApiMessagesByConversationId');
    Route::get('/api/users','MessageController@getApiUsers');
    Route::post('/api/messages/answer','MessageController@insertMessageToConversation');
    Route::post('/api/messages/new','MessageController@createConversation');
    Route::get('/api/messages/check','MessageController@checkNewMessage');


    Route::get('contacts','ContactsController@indexView');
    Route::get('/api/contacts','ContactsController@apiGetContacts');
    Route::post('/api/contact/new','ContactsController@apiCreateContact');
    Route::post('/api/contact/update','MessageController@createConversation');




    Route::get('messages','MessageController@getConversation');
    Route::get('message/{id}','MessageController@getMessagesByConversationId');
    Route::get('messages/new','MessageController@createConversationView');
    Route::post('messages/new','MessageController@createConversation');
    Route::post('messages/answer','MessageController@insertMessageToConversation');






//    Route::get('workhours/date-range/{start}/{end}', 'ConversationController@listView');




});

