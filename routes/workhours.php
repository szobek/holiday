<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2018. 07. 02.
 * Time: 7:27
 */

Route::get('checkin', function() {
    $users = \App\User::all();
    return view('workhours/index', compact('users'));
});

Route::post('checkin', 'checkinController@createRow');
/*Route::post('checkin', function(\Illuminate\Http\Request $request) {
    $c = new \App\Http\Controllers\checkinController();
    $c->createRow($request);
});*/

