<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Permission;
use App\User;
use App\UserCompanies;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public $user_permission;

    function __construct()
    {
        $userId = Auth::user();
//        $userId = User::find(4);
        $this->user_permission = $userId->permissionList;
        $this->user_permissionIds = $userId->permission_list_ids;
    }


    /**
     * Megjeleníti a user listát
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function userList()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Megjeleníti egy adott user profil oldalát
     *
     * @author norbi
     *
     */
    public function userEditView($id)
    {
        if ((int)$id === Auth::user()->id || in_array(3, $this->user_permissionIds)) {
        } else
            dd("nem nézheti meg az oldalt", $this->user_permissionIds);


        $pl = $this->user_permissionIds;
        $user = User::find($id);
        if (!count($user)) return abort(404);
        $companies_list = $user->getCompanies();
        $companies = Companies::all();
        $delete = true;
        if (!count($companies)) return abort(404);
        $action = '/user/profile';
        return view('users.profile', compact('user', 'companies', 'action', 'delete', 'companies_list', 'pl'));
    }

    /**
     * Elmenti a userhez a cégeket,
     * @param $user_id integer: a felhasználó id-ja | $companies Array Egy tömb, amiben megkapja front-endről, hogy kikhez tartozik
     * @author norbi
     * @return
     */
    public static function setCompanies($user_id, $companies = [])
    {
        if ($companies == null) $companies = [];
        $del = UserCompanies::where('user_id', $user_id);
        if ($del !== null) $del->delete();

        foreach ($companies as $company) {
            UserCompanies::create([
                "user_id" => $user_id,
                "companies_id" => $company
            ]);
        }
    }

    /**
     * Elmenti az adott user adatait és beállítja a cégeket a userhez
     *
     */
    public function saveUser($request)
    {

        if (!cp(4, $this->user_permissionIds)) {
            dd("Nem szerkesztheti");
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->holidays = $request->holidays;
        $user->telephone = $request->telephone;

        self::setCompanies($request->id, $request->companies);

        if (self::setNewPassword($request->passwordo, $request->password, $request->password2)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back();

    }

    /**
     *
     * @author norbi
     * @return bool
     */
    public static function setNewPassword($old, $new1, $new2)
    {

        return (
            $new1 !== "" &&
            strlen($new1) >= 8 &&
            password_verify($old, Auth::user()->getAuthPassword()) &&
            $new1 === $new2
        );
    }

    public static function newUserView()
    {

        $companies = Companies::all();
        if (!count($companies)) return abort(404);


        $user = new Collection();
        $user->id = "";
        $user->name = "";
        $user->email = "";
        $user->password = "";
        $user->holidays = 0;
        $user->telephone = 0;

        $companies_list = new Collection();
        $action = '/user/new';
        $psw = true;
        return view('users.profile', compact('user', 'action', 'companies', 'psw', 'companies_list'));
    }


    public static function newUser($request)
    {
        $data = $request->all();

        /*$validator  = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'company' => 'required',
            'password' => 'required',
        ]);

        dd($validator->errors());
        $errors = $validator->errors();*/

        if ($request->password !== $request->password2) return redirect()->back();


        unset($data->id);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        self::setCompanies($user->id, $request->companies);
        return redirect('/users');
    }


    /**
     *
     * @author norbi
     * @return bool
     */
    public function userDelete($id)
    {
        if (!isset($id) || $id == '') return abort(404);
        $user = User::find($id);
        if ($user == null) return abort(404);

        $user->delete();

        return redirect()->to('/');

    }

    public function hash($string)
    {
        return Hask::make($string);

    }

    /**
     * Ellenőrzi, hogy van-e még elég szabad napja
     * @author norbi
     * @return
     */
    public static function checkFreeHolidays($user, $diff)
    {
        return ($user->holidays >= $diff);

    }


}
