<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2018. 07. 02.
 * Time: 7:27
 */

Route::get('checkin', function() {
    if($_SERVER['SERVER_NAME'] !== 'vh.i234.me') { // ha kívülről próbálják elérni, akkor 404
        $users = \App\User::all();
        return view('workhours/index', compact('users'));
    } else {
        abort(404);
    }

});

Route::post('checkin', 'checkinController@createRow');
