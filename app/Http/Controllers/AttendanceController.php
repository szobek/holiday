<?php

namespace App\Http\Controllers;

use App\Companies;
use App\NonWorking;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    private $test;

    function __construct()
    {
        $this->test = true;
    }

    public function pdf($year = null, $month = null, $user_id = null, $company_id = null) {


        Carbon::setLocale('hu');

        if($year == null || $month == null || $user_id == null) dd('Nincs dátum vagy cég');


        $user = User::find($user_id);
        if(count($user) < 1) {
            dd('hiba a user find-ban');
            return abort(404);
        }


        if($this->checkUserInCompany($user, $company_id)) {

            $company = Companies::find($company_id);
        } else {
            dd('hiba a user company-ban');
            return abort(404);
        }

        if(count($company) < 1 ){
            dd('hiba a company keresésben');
            return abort(404);
        }


        /**
         * lekéri a userek szabadságait adott évre
         */
        $temp = self::getHoliDaysSimpleUser($year, $month, $company, $user_id);
        $holidays = (count($temp['holidays'])) ? $temp['holidays'] : [];
        $cheats = (count($temp['cheats'])) ? $temp['cheats'] : [];
        $start_day = Carbon::parse("$year-$month-01");
        $non_working = NonWorking::where('year', $year)->where('type','holiday')->get()->toArray();
        $saturdayWork = NonWorking::where('year', $year)->where('type','work')->get()->toArray();

        $end_day = $start_day->copy()->endOfMonth();
        $temp = $start_day->copy();


//        dd($temp);
        $items = [];
        while($temp <= $end_day) {

            // hétvégi munka
            if(self::hasSaturdayWork($saturdayWork, $temp->format('Y-m-d')) && !in_array($temp->format('Y-m-d'), $holidays))
                $items[] = ["num" => $temp->format('d'), 'disabled' => false];
            // hétvége
            else if($temp->isWeekend())
                $items[] = ["num" => $temp->format('d'), 'disabled' => true];
            // szabadságok
            else if(in_array($temp->format('Y-m-d'), $holidays)) {
                $cheat = (in_array($temp->format('Y-m-d'), $cheats));
//                 dd($cheats, $holidays, $cheat);
                if($cheat) {
                    $items[] = ["num" => $temp->format('d'), 'disabled' => false, 'holiday' => false];
                } else {
                    $items[] = ["num" => $temp->format('d'), 'disabled' => true, 'holiday' => true];
                }

            }


            // munkaszüneti nap
            else if(count($non_working) > 0 && self::hasNonwork($non_working,$temp->format('Y-m-d')))
                $items[] = ["num" => $temp->format('d'), 'disabled' => true];
            // azok a napok, amik előző évről maradtak...

            // egyéb
            else
                $items[] = ["num" => $temp->format('d'), 'disabled' => false];
            $temp = $temp->copy()->addDay();
        }


        /**
         * ez kell a selecthez
         */
        $years = [];
        $months = [];
        for($i = 1; $i<13; $i++) $months[] = $i;
        for($i = 2017; $i<2025; $i++) $years[] = $i;


        $month = $start_day->copy()->format('F');

//        dd($items);

        return view('pdf.jelenleti', compact('items','user', 'company', 'year', 'month','years', 'months'));

    }

    public function getHoliDaysAllUser($year, $month, $company) {
        $events = CalendarController::findAllEventOfYearData($year, $month);
        $users = [];
        $temp = [];
        foreach ($events as $event) {
            if($event['company_id'] ===  $company->id) {
                $users[$event['user_id']][] = $event;
            }
        }

        foreach ($users as &$user) {
            foreach ($user as &$u) {
                $temp[$u['user_id']][] = $u['start'];
                $diff = $u['start']->diffInDays($u['end']);
                $u['holidays'][] = $u['start'];
                $added = $u['start']->copy();
                for($i = 0; $i<$diff; $i++) {
                    $added = $added->copy()->addDay();
                    $u['holidays'][] = $added;
                    $temp[$u['user_id']][] = $added;
                }
            }
        }

        return [
            'users' => $users,
            'temp' => $temp,
        ];

    }

    /**
     *
     *
     * @author norbi
     * @return bool
     */
    public static function hasNonwork($nonWorkDays, $day){
        $has = false;
        foreach ($nonWorkDays as $nonday) {
            if($nonday['date'] === $day) $has = true;
        }
        return $has;
    }

    /**
     *
     *
     * @author norbi
     * @return bool
     */
    public static function hasSaturdayWork($saturdays, $day){
        $has = false;
        foreach ($saturdays as $satday) {
            if($satday['date'] === $day) $has = true;
        }
        return $has;
    }

    /**
     * @param $year
     * @param $month
     * @param $company
     * @param $user_id
     * @return array
     */
    public function getHoliDaysSimpleUser($year, $month, $company, $user_id) {
        $events = CalendarController::findAllEventOfYearData($year, $month);
        $user_events = [];
        $temp = [];
        $cheats = [];

//        dd($events,$user_id);

        foreach ($events as $event) {
            if($event['company_id'] ===  $company->id && $event['user_id'] == $user_id) {
                $user_events[] = $event;
            }
        }


        foreach ($user_events as &$u) {
            $temp[] = $u['start']->format('Y-m-d');
            if($u["type_id"] == 4)
                $cheats[] = $u['start']->format('Y-m-d');
            $diff = $u['start']->diffInDays($u['end']);
            $added = $u['start']->copy();
            for($i = 0; $i<$diff; $i++) {
                $added = $added->copy()->addDay();
                $temp[] = $added->format('Y-m-d');
            }
        }


        $ret =  [
            "holidays" => $temp,
            "cheats" => $cheats,
        ];

        return $ret;
    }

    public function checkUserInCompany($user, $company_id) {
        $check = false;

//        dd($user, $company_id);
        foreach ($user->company_list->toArray() as $company) {
            if($company['id'] === (int)$company_id) {
                $check = true;
                break;
            };
        }

        return $check;
    }

    /**
     * @author norbi
     * @return
     */
    public static function getCompaniesListByPermission(){
        $companies = [];
        if(cp(1, Auth::user()->permission_listIds)){
            $companies = \App\Companies::all();
        } else {
            $companies = Auth::user()->company_list;
        }

        return $companies;
    }

    /**
     * @author norbi
     * @return
     */
    public static function getUserListByPermission(){
        $users = [];
        if(cp(1, Auth::user()->permission_listIds)){
            $users = \App\User::all();
        } else {
            $users = [Auth::user()];
        }

        return $users;
    }

}
