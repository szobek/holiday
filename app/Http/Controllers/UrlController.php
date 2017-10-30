<?php

namespace App\Http\Controllers;

use App\Companies;
use App\HolidayTypes;
use App\Mail\HolidayMaked;
use App\NonWorking;
use App\User;
use Illuminate\Support\Facades\Mail;
use \PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UrlController extends Controller
{
    public function welcome(Request $request, $year = "")
    {

        if($year == "") $year = date('Y-m-d'); // ha nincs megadva, akkor az aktuális évet választom

        $events = CalendarController::findAllEventOfYearData($year);


        return view('list.table', compact('events'));
    }

    /**
     * ellenőrzi, hogy az event egész napos vagy csak pár órás
     */
    public static function checkEventDayFormat($event){
        return is_null($event->start->date) ? false : true;
    }

    public function createEvent(Request $request) {

        $msg = [];

        $request->validate([
            'name' => 'required',
            'company' => 'required|max:5|min:1',
            'start' => 'required',
            'end' => 'required',
        ]);


        $user = User::find($request->name);
        if($user == null) {
            $msg = [
                "title" => "Hibás user",
                "type" => "danger",
            ];
            return redirect()->back()->with(["msg"=>$msg]);
        }

        $company_data = Companies::find($request->company);
        $company = ($company_data !== null) ? $company_data->short_name : "n/a" ;
        $company_id = ($company_data !== null) ? $company_data->id : "n/a" ;

        $name = $user->name;
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $description = $request->description;

        if($start > $end) {
            $msg = [
                "title" => "Hibás dátum",
                "type" => "danger",
            ];
            return redirect()->back()->with(["msg"=>$msg]);
        }

        $h_type = HolidayTypes::find($request->type);

        $data = [
            "name" => $name,
            "start" => $start,
            "end" => $end,
            "description" => $description,
            "company" => $company,
            "company_id" => $company_id,
            "type" => $h_type->name,
            "type_id" => $h_type->id,
            "user_id" => $user->id,

        ];
        $success = CalendarController::createFulldayEvent($data);

        if(gettype($success) == "object") return redirect()->back()->with($msg); else dd( gettype($success));
    }

    public function modifyEventView($id){
        $event = CalendarController::getEvent($id);

        if
        (
            $event == null ||
            count($event) < 1 ||
            $event->googleEvent->status == "cancelled"
        )
            return abort(404);
        $event_data = CalendarController::getEventDesc($event);

        return view('list.update', compact('event_data'));

    }

    public function modifyEvent(Request $request){


        $type = HolidayTypes::find($request->type);
        $req = $request;
        $req->type = $type->name;
        $req->type_id = $type->id;

        $data = CalendarController::updateFulldayEvent($req);


        if($data) {
            return redirect('/');
        } else {
            return abort(404);
        }
    }

    public function deleteEvent(Request $request) {
        return CalendarController::deleteEvent($request->id);
    }

    public function pdf($year = null, $month = null, $user_id = null) {

        Carbon::setLocale('hu');

        if($year == null || $month == null || $user_id == null) dd('Nincs dátum vagy cég');


        $user = User::find($user_id);
//        dd($user, $user_id);/
        if(count($user) < 1)
            return abort(404);

        $company = Companies::find($user->company);
        if(count($company) < 1)
            return abort(404);

        $events = CalendarController::findAllEventOfYearData($year, $month);

        if(count($events) < 1) return redirect('/')->with('msg', ['title' => 'Nincs adat', 'type' => 'danger']);

        $holidays = self::getHoliDaysSimpleUser($year, $month, $company, $user_id);

        $start_day = Carbon::parse("$year-$month-01");
        $end_day = $start_day->copy()->endOfMonth();

        $non_working = NonWorking::where('year', $year)->get()->toArray();

//        dd($non_working[0]);

        $temp = $start_day->copy();
        $items = [];
        while($temp <= $end_day) {
            if(in_array($temp->format('Y-m-d'), $holidays))
                $items[] = ["num" => $temp->format('d'), 'disabled' => true];
            else if($temp->isWeekend())
                $items[] = ["num" => $temp->format('d'), 'disabled' => true];
            else if(in_array($temp->format('Y-m-d'), $non_working[0]))
                $items[] = ["num" => $temp->format('d'), 'disabled' => true];
            else
                $items[] = ["num" => $temp->format('d'), 'disabled' => false];
            $temp = $temp->copy()->addDay();
        }




        $month = $start_day->copy()->format('F');

        return view('pdf.jelenleti', compact('items','user', 'company', 'year', 'month'));

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

        foreach ($events as $event) {
            if($event['company_id'] ===  $company->id && $event['user_id'] == $user_id) {
                $user_events[] = $event;
            }
        }


        foreach ($user_events as &$u) {
            $temp[] = $u['start']->format('Y-m-d');
            $diff = $u['start']->diffInDays($u['end']);
            $added = $u['start']->copy();
            for($i = 0; $i<$diff; $i++) {
                $added = $added->copy()->addDay();
                $temp[] = $added->format('Y-m-d');
            }
        }

        return $temp;
    }

    public function usersView() {
        return UserController::userList();


    }

    public function usersProfile($id = null) {
        if($id == null) abort(404);
        return UserController::userEdit($id);
    }

    public function usersNewView() {
        return UserController::newUserView();
    }

    public function usersNew(Request $request) {
        return UserController::newUser($request);
    }


    public function usersProfileUpdate(Request $request) {
        return UserController::saveUser($request);
    }

    public function nonWorkingView($year = null) {
        if(!isset($year) || $year == null) $year = date('Y');
        return NonWorkingController::nonWorkingListView($year);
    }

    public function listCompaniesView()  {
        return CompaniesController::listCompanies();
    }

    public function companyProfile($id){
        if($id == null) abort(404);
        return CompaniesController::companyProfile($id);
    }

    public function companySave(Request $request) {
        return CompaniesController::saveCompany($request);
    }

    public function companyNewView(){
        return CompaniesController::newCompanyView();
    }

    public function companyNew(Request $request) {
        return CompaniesController::newCompany($request);
    }

    /**
     *
     *
     * @author norbi
     */
    public function testMail(){

        return new HolidayMaked();
//        Mail::send(new HolidayMaked());
    }

}
