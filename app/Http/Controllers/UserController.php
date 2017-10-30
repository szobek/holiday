<?php

namespace App\Http\Controllers;

use App\Companies;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public static function userList() {
        $users = User::all();
//        dd($users);

        return view('users.index', compact('users'));
    }

    /**
     *
     *
     * @author norbi
     *
     */
    public static function userEdit($id){
        $user = User::find($id);
        if(!count($user)) return abort(404);

        $companies = Companies::all();
        if(!count($companies)) return abort(404);
        $action = '/user/profile';
        return view('users.profile', compact('user', 'companies', 'action'));
    }

    /**
     *
     *
     */
    public static function saveUser($request){

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->save();

        return redirect()->back();

    }

    public static function newUserView(){

        $companies = Companies::all();
        if(!count($companies)) return abort(404);


        $user = new Collection();
        $user->id = "";
        $user->name = "";
        $user->email = "";
        $user->company = "";
        $user->password = "";

        $action = '/user/new';
        $psw = true;
        return view('users.profile', compact('user', 'action', 'companies', 'psw'));
    }


    public static function newUser($request){
        $data = $request->all();

        /*$validator  = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'company' => 'required',
            'password' => 'required',
        ]);

        dd($validator->errors());
        $errors = $validator->errors();*/

        if($request->password !== $request->password2) return redirect()->back();


        unset($data->id);
        User::create($data);
        return redirect('/users');
    }


}
