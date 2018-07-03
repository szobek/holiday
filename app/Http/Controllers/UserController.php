<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Holiday;
use App\Mail\RegistrationByUserValidate;
use App\Permission;
use App\User;
use App\UserCompanies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public $user_permission;

    function __construct()
    {

        $userId = Auth::user();
        $this->user_permission = $userId->permissionList;
        $this->user_permissionIds = $userId->permission_list_ids;

    }


    /**
     * Megjeleníti a user listát
     * @return Response
     */
    public function userList()
    {
        if(!cp(9, $this->user_permissionIds)) {
            return abort( 403);
        }
        $users = User::all();
        return view('users/index', compact('users'));
    }


    /**
     * Megjeleníti egy adott user profil oldalát
     *
     * @author norbi
     *
     */
    public function userEditView($id)
    {

        if ((int)$id === Auth::user()->id || cp(3, $this->user_permissionIds)) {
        } else {
//            dd2("nem nézheti meg az oldalt");
            abort(403);
        }
        $pl = $this->user_permissionIds;
        $user = User::find($id);

        $companies_list = $user->getCompanies();

        $companies = Companies::all();
        $delete = true;
        if (!count($companies)) return abort(404);
        $action = '/user/profile';


        /*** user szabadságai */
        $year = date('Y');
//        $events = CalendarController::findAllEventOfYearData($year);
        $events = HolidayController::serachByKey("user_id%3D$id");
//        dd($events);

        $userEvents = [];
        foreach ($events as $event) {
            $userEvents[] = CalendarController::getPrivateData($event);
        }

        /****/

        $hcc = new HolidayCountController();
        $allHoliday = $hcc->countUserHoliday(Carbon::now()->year, $id);


        return view('users/profile', compact('user', 'companies', 'action', 'delete', 'companies_list', 'pl', 'userEvents', 'allHoliday'));
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

        $msg = [
            "type" => "danger",
            "title" => "",
        ];
        $permission = [
            "alldata" => ((Auth::user()->id === (int)$request->id && cp(7, $this->user_permissionIds)) || cp(4, $this->user_permissionIds)),
            "password" => Auth::user()->id === (int)$request->id
        ];


        $user = User::find($request->id);

        /*$user->password = bcrypt('123456789');
        $user->save();

        dd('vége', $user);*/

        if($permission['alldata']) {
            if(isset($request->name)) $user->name = $request->name;
            if(isset($request->email)) $user->email = $request->email;
            if(isset($request->holidays)) $user->holidays = $request->holidays;
            if(isset($request->telephone)) $user->telephone = $request->telephone;
            self::setCompanies($request->id, $request->companies);
        } else {
            $msg['title'] .= "Nincs jogod | ";
        }

        if($permission['password']) {
//            dd($request->passwordo);
            if($request->passwordo !== null)
                if (self::setNewPassword($request->passwordo, $request->password, $request->password2)) {
                    $user->password = bcrypt($request->password);
                } else {
                    $msg['title'] .= "Nem jók a jelszavak | ";
                    return redirect()->back()->with(["msg"=>$msg]);
                }
        }

        $msg['title'] .= "User mentve";
        $msg['type'] = "success";
        $user->save();


        return redirect()->back()->with(["msg"=>$msg]);

    }

    /**
     *
     * @author norbi
     * @return bool
     */
    public static function setNewPassword($old, $new1, $new2)
    {

        $equal = ($new1 === $new2);
        $notEmpty = ($new1 !== "");
        $length = (strlen($new1) >= 8);
        $verify_old = password_verify($old, Auth::user()->getAuthPassword());

        return (
            $notEmpty &&
            $length &&
            $verify_old &&
            $equal
        );
    }

    public function newUserView()
    {

        if(!cp(8, $this->user_permissionIds)) {
            return abort(403);
        };
        $pl = [];
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
        return view('users.profile', compact('user', 'action', 'companies', 'psw', 'companies_list', 'pl'));
    }


    public function newUser($request)
    {
        if(!cp(8, $this->user_permissionIds)) {
            return redirect()->to('/');
        };
        $data = $request->all();
        if ($request->password !== $request->password2) return redirect()->back();


        unset($data->id);
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        self::setCompanies($user->id, $request->companies);
//        $mail = new RegistrationByUserValidate($user, $pass);

        // TODO kell küldeni majd egy mailt...
/*        if(Mail::send($mail)) {

        } else {
            dd('hiba az email küldésnél');
        }*/


        return redirect('/users');
    }


    /**
     *
     * @author norbi
     * @return bool
     */
    public function userDelete($id)
    {

        if(cp(11, $this->user_permissionIds)) {
            if (!isset($id) || $id == '') return abort(404);
            $user = User::find($id);
            if ($user == null) return abort(404);
            $user->delete();
        } else {
            abort(403);
        }
        return true;

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
