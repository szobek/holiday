<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{

	public static function hashing($userId, $password) {
		$user = User::find($userId);
		$user->password = Hash::make($password);
		$user->save();
		print "ok";
	}

}
