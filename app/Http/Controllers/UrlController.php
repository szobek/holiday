<?php

namespace App\Http\Controllers;

use App\Companies;
use App\HolidayTypes;
use App\Mail\HolidayMaked;
use App\Mail\RegistrationByUserValidate;
use App\NonWorking;
use App\User;
use Google_Service_Calendar_EventExtendedProperties;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use \PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\GoogleCalendar\Event;

class UrlController extends Controller
{
    private $feature;

    function __construct()
    {
        $this->feature = [
            'holi_days' => false
        ];
    }


    public function welcome(Request $request, $year = "")
    {
//        dd('http://' . $request->getHttpHost());



        if($year == "") $year = date('Y-m-d'); // ha nincs megadva, akkor az aktuális évet választom
        $events = CalendarController::findAllEventOfYearData($year);
        return view('list/table', compact('events'));
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

        // Hány napot foglal le...
        $diff = $start->diffInDays( $end) + 1;
        // ha nincs elég szabija


        if($this->feature['holi_days'])
            if(!UserController::checkFreeHolidays($user, $diff)) {
                $msg = [
                    "title" => "Kevés a szabid",
                    "type" => "danger",
                ];
                return redirect()->back()->with(["msg"=>$msg]);
            }



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
            "accepted" => 0

        ];



        $success = CalendarController::createFulldayEvent($data);
        $data['eventId'] = $success->id;


        if(gettype($success) == "object") return redirect()->back()->with($msg); else dd( gettype($success));
    }

    public function modifyEventView($id){


        // TODO itt még alakítani kell!!!
        $event = CalendarController::getEvent($id);
//        dd($event->googleEvent->getExtendedProperties()->private);


        if
        (
            $event == null ||
            $event->googleEvent->status == "cancelled"
        )
            return abort(404);

//        $event_data = CalendarController::getEventDesc($event);
        $event_data = CalendarController::getPrivateData($event);

        if(($event_data['user_id'] === Auth::user()->id && cp(16,Auth::user()->getPermissionIds()) ) || cp(15,Auth::user()->getPermissionIds())) {

        }

        return view('list/update', compact('event_data'));

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
            return abort(403);
        }
    }

    /**
     * @author norbi
     * @return
     */
    public function viewEvent(Request $request, $id){

        return CalendarController::viewEvent($request);
    }

    public function deleteEvent(Request $request) {
        return CalendarController::deleteEvent($request->id);
    }

    public function usersView() {
        $userController = new UserController();
        return $userController->userList();
    }

    public function usersProfile($id = null) {
        if($id == null) abort(404);
        $uc = new UserController();
        return $uc->userEditView($id);
    }

    public function usersNewView() {

        $u = new UserController();

        return $u->newUserView();
    }

    public function usersNew(Request $request) {
        $u = new UserController();

        return $u->newUser($request);

    }

    public function usersProfileUpdate(Request $request) {
        $uc = new UserController();
        return $uc->saveUser($request);
    }

    public function userDelete($id) {

        $u = new UserController();
        if($u->userDelete($id));
            return redirect()->to('/');
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
    public function testMail($holidayData){


        $mail = new HolidayMaked($holidayData);
        dd($mail);
        return Mail::send($mail);
//        Mail::send(new HolidayMaked());
    }

    public static function convert( $str ) {
        return iconv( "Windows-1252", "UTF-8", $str );
    }

    public static function csvTest(){
        return;
        $url = url("/upload/nonw.csv");

        ini_set('auto_detect_line_endings',TRUE);
        $file = fopen($url, "r");

        $rows = 0;

        while (($data = fgetcsv($file, 0, "\r")) !== FALSE) {
            if($rows > 0) { // origin 0
                $row = explode(";", $data[0]);
                $row = array_map("self::convert", $row);
                NonWorking::create([
                    "name" => $row[2],
                    "date" => $row[1],
                    "year" => $row[0],
                    "description" => $row[3],
                    "type" => $row[4],
                ]);

            }
            $rows++;

        }



        ini_set('auto_detect_line_endings',FALSE);
        return "readCsv megvolt";
    }

    /**
     * @author norbi
     * @return
     */
    public function searchEventView(){
        $events = [];
        return view('list/search')->with(["events" => $events]);
    }

    /**
     * @author norbi
     * @return
     */
    public function searchEvent(Request $request){

        //        $temp = Event::get(null, null, ['privateExtendedProperty' => 'a%3Dusa']);


        $events = HolidayController::serachByKey("user_id%3D$request->name");
        dd($events);
        return view('list/search')->with(["events" => $events]);
    }


    /**
     * @author norbi
     * @return
     */
    public function routeTest(){
        dd('llllll');
    }


}
