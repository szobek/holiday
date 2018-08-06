<?php

namespace App\Http\Controllers;

use App\Companies;
use App\NonWorking;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event;

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
        if($user === null) {
            dd('hiba a user find-ban');
            return abort(404);
        }


        if($this->checkUserInCompany($user, $company_id)) {

            $company = Companies::find($company_id);
        } else {
            dd('hiba a user company-ban');
            return abort(404);
        }

        if($company === null){
            dd('hiba a company keresésben');
            return abort(404);
        }


        /**
         * lekéri a userek szabadságait adott évre és hónapra
         */
        $temp = self::getHoliDaysSimpleUser($year, $month, $company, $user_id);

        $start_day = \Carbon\Carbon::create($year, $month)->startOfMonth();
        $end_day = $start_day->copy()->endOfMonth();
        $tempDay = $start_day->copy();

        $non_working = NonWorking::where('year', $year)->where('type','holiday')->get()->toArray(); // munkaszüneti napok
        $saturdayWork = NonWorking::where('year', $year)->where('type','work')->get()->toArray();

        $pdfData = [];


        while($tempDay <= $end_day) {
            $tempData = new \stdClass();
            $tempData->num = $tempDay->format('d');
            if(AttendanceController::isSick($tempDay->format('Y-m-d'), $temp)) {
                $tempData->workDay = true;
                $tempData->sick = true;

            }
            // hétvégi munka
            else if(self::hasSaturdayWork($saturdayWork, $tempDay->format('Y-m-d')) ) {
                $tempData->workDay = true;
                $tempData->holiday = (AttendanceController::isHoliday($tempDay->format('Y-m-d'), $temp)) ? true : false;
                $tempData->sick = false;
            }
            // nem szombat, csak sima szabi
            else if(AttendanceController::isHoliday($tempDay->format('Y-m-d'), $temp)) {
                $tempData->workDay = true;
                $tempData->holiday = true;
                $tempData->sick = false;
            }
            // hétvége
            else if($tempDay->isWeekend()) {
                $tempData->workDay = false;
                $tempData->holiday = false;
                $tempData->sick = false;
            }

            // munkaszüneti nap
            else if(count($non_working) > 0 && self::hasNonwork($non_working,$tempDay->format('Y-m-d'))) {
                $tempData->workDay = false;
                $tempData->holiday = false;
                $tempData->sick = false;
            }

            else {
                $tempData->workDay = true;
                $tempData->holiday = false;
                $tempData->sick = false;
            }

            if($tempData->workDay && !$tempData->holiday) {
                $tempData->start = "08:00";
                $tempData->end = "17:00";
                $tempData->all = "8";
            }


            $pdfData[] = $tempData;
            $tempDay = $tempDay->copy()->addDay();
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

        return view('pdf/jelenleti', compact('pdfData','user', 'company', 'year', 'month','years', 'months'));

    }
    
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function dayType(){

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
            if($satday['date'] === $day) {
                $has = true;
                break;
            }

        }
        return $has;
    }

    /**
     * @author norbi
     * @return
     */
    public static function isHoliday($day, $holidays){
        $result = false;
        foreach ($holidays as $holiday) {
            if($holiday['type_id'] == 1 && $holiday['date'] == $day) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    public static function isSick($day, $holidays){
        $result = false;
        foreach ($holidays as $holiday) {
            if($holiday['type_id'] == 2 && $holiday['date'] == $day) {
                $result = true;
                break;
            }
        }
        return $result;
    }





    /**
     * @param $year
     * @param $month
     * @param $company
     * @param $user_id
     * @return array
     */
    public function getHoliDaysSimpleUser($year, $month, $company, $user_id, $end = null) {

        $start = Carbon::parse("$year-$month-01");

        if(is_null($end)) {
            $end = $start->copy()->endOfMonth();
        }

        $req = ["user_id=$user_id", "company_id=$company->id"];
        $events = Event::get($start, $end, ['privateExtendedProperty' => $req]);

        $eventRows = []; // ebbe kerül az eventek listája nap szerint bontva

//        dd($events);
        // eventek listája
        foreach ($events as $eventRow) {

            // lekérem az event adatait
//            $desc = CalendarController::getEventDesc($eventRow);
            $desc = CalendarController::getPrivateData($eventRow);


            // a dátumok differenciája
            $diff = $desc['start']->diffInDays($desc['end']);
            $added = $desc['start']->copy();
            for($i = 0; $i<=$diff; $i++) {
                $eventRows[] = [
                    "type" => $desc['type_id'],
                    "date" => $added->toDatestring(),
                    "type_id" => $desc['type_id'],
                ];
                // növelem a dátumot
                $added = $added->copy()->addDay();
            }

        }


        return $eventRows;

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
