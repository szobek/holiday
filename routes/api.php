<?php

use Illuminate\Http\Request;

Route::middleware('api')->any('/tester', 'TestController@saveFile');

