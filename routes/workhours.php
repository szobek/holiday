<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2018. 07. 02.
 * Time: 7:27
 */

Route::get('checkin', 'checkinController@checkinView');

Route::post('checkin', 'checkinController@checkIn');
