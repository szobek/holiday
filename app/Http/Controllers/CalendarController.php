<?php

namespace App\Http\Controllers;

use App\Companies;
use App\User;
use Carbon\Carbon;
use DateTimeZone;
use Google_Service_Calendar_EventExtendedProperties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\GoogleCalendar\Event;

/**
 * Class CalendarController
 * @package App\Http\Controllers
 */
class CalendarController extends Controller
{

    /**
     * Generál egy stringet a szabadság nevének
     *
     * @author norbi
     * @return string
     */
    public static function setEventName($name)
    {
        return "Szabadság - $name";
    }


    /**
     * @author norbi
     * @return
     */
    public static function setPrivateData($obj){
        $privateData = new Google_Service_Calendar_EventExtendedProperties();
        $privateData->setPrivate($obj);
        return $privateData;
    }

    public static function getPrivateData($event) {
        $private = (isset($event->googleEvent->getExtendedProperties()->private)) ? $event->googleEvent->getExtendedProperties()->private : null;
        if($private !== null) {
            $private['id'] = $event->googleEvent->id;
            $private['start'] = Carbon::parse($event->googleEvent->getStart()->date);
            $private['end'] = Carbon::parse($event->googleEvent->getEnd()->date)->subDay(1);
        }
        return $private;

    }

    /**
     * Készít egy egész napos eventet a naptárba
     * @param $obj array {name: 'ez a név', start: '2017-10-10', end: '2017-10-10', description: 'ez egy szabadság...'}
     * @return Event
     */
    public static function createFulldayEvent($obj)
    {
        $event = new Event;
        $event->name = self::setEventName($obj["name"]);

        $event->__set('start.date', Carbon::parse($obj["start"])->setTimezone('Europe/Budapest'));
        $event->__set('end.date', Carbon::parse($obj["end"])->addDay(1)->setTimezone('Europe/Budapest'));



        if(!isset($obj["description"])) {
            $obj["description"] = "";
        }


        $privateData = self::setPrivateData($obj);

        // eddig ez volt...
//        $event->description = json_encode($obj);

        // most beállítom a privát adatokat
        $event->googleEvent->setExtendedProperties($privateData);


//        dd(self::getEventDesc($event));
        $calendarEvent = $event->save();

        return $calendarEvent;
    }

    /**
     *
     *
     * @author norbi
     * @return boolean
     */
    public static function updateFulldayEvent($request)
    {
//        dd($request->description, isset($request->description));

        $event = CalendarController::getEvent($request['id']);// lekérem az eventet

        //beállítom a dátumokat az eventben
        $event->__set('start.date', Carbon::parse($request["start"])->setTimezone('Europe/Budapest'));
        $event->__set('end.date', Carbon::parse($request["end"])->addDay(1)->setTimezone('Europe/Budapest'));

        // beállítom a desc-t
//        $_desc = json_decode($event->googleEvent->description);
        $descTemp = self::getPrivateData($event);
        $desc = (object) $descTemp;

        $desc->start = Carbon::parse($request["start"]);
        $desc->end = Carbon::parse($request["end"]);
        $desc->description = (isset($request->description)) ? $request->description : "N/A";
        $desc->type = $request->type;
        $desc->type_id = $request->type_id;
        $desc->accepted = $request->accepted;
        $desc->company_id = $request->company;
        $desc->company = Companies::find($request->company)->short_name;
        $desc->name = $request->name;
//        $desc->user_id = 14;

//        $event->__set('description', json_encode($desc));
        // beállítom a privát adatokat
        $privateData = self::setPrivateData($desc);
//        $privateData = new Google_Service_Calendar_EventExtendedProperties();
//        $privateData->setPrivate($desc);


        // ha elfogadja, akkor átállítom az accepted kulcsot
        $event->__set('accepted', $request->accepted);

        // beállítom a privát adatokat
        $event->googleEvent->setExtendedProperties($privateData);

        $event->save();
        return true;

    }

    /**
     * Event lekérés id alapján
     *
     * @param $id string
     * @author norbi
     * @return Event
     */
    public static function getEvent($id = null)
    {
        return ($id !== null) ? Event::find($id) : null;
    }

    public static function viewEvent($request) {

        // TODO itt be kell tenni a permissiont, mert egyenlőre mindenki megtekintheti
//        dd(session()->get('permissions'));
//        dd(self::getPrivateData($googleEvent));




        $googleEvent = CalendarController::getEvent($request->id);
        $event = self::getPrivateData($googleEvent);
//        $event = CalendarController::getEventDesc($googleEvent);

        if($event['user_id'] === Auth::user()->id || cp(17, session()->get('permissions'))) {
            if($googleEvent->googleEvent->status === "cancelled")
                abort(404);

            return view('list/view')->with('event', $event);
        } else {
            return abort(403);
        }


    }


    public static function findAllEventOfYearData($year, $month = null)
    {

        if (!isset($month) || $month === null) {
            $monthStart = 1;
            $monthEnd = 12;
        } else {
            $monthStart = $month;
            $monthEnd = $month;
        }
        $start = Carbon::create($year, $monthStart, 1, 0, 0, 0);
        $end = Carbon::create($year, $monthEnd, 31, 23, 59, 59);

        $parameters = [
            "timeMin" => Carbon::parse($start)->format(config('google-calendar.format')),
            "timeMax" => Carbon::parse($end)->format(config('google-calendar.format')),
        ];

        $events = Event::get(null, null, $parameters);


        $returned = [];

        $perm_own_company = cp(6, Auth::user()->permission_listIds); // csak a saját cégeinek a szabadsága
        $perm_all_company = cp(2, Auth::user()->permission_listIds); // minden szabadságot lát

        foreach ($events as $event) {
//            $return_event = self::getEventDesc($event);

            $return_event = self::getPrivateData($event);
//            dd($return_event);

            if ($perm_all_company) {
                $returned[] = $return_event;
            } else if ($perm_own_company) {
                $ids = Auth::user()->company_list->pluck('id')->toArray();
                if (in_array($return_event['company_id'], $ids)) {
                    $returned[] = $return_event;
                }
            }
        }
        return $returned;
    }


    public static function getEventDesc($event)
    {
//        dd($event->googleEvent->getExtendedProperties()->private);
        $private_data = (isset($event->googleEvent->getExtendedProperties()->private)) ? $event->googleEvent->getExtendedProperties()->private : null;
//        dd($private_data);
        $obj = json_decode($event->googleEvent->description);
        $start = Carbon::parse($event->googleEvent->getStart()->date);
        $end = Carbon::parse($event->googleEvent->getEnd()->date)->subDay(1);
        return [
            "name" => (isset($obj->name)) ? $obj->name : 'N/A',
            "user_id" => (isset($obj->user_id)) ? $obj->user_id : 'N/A',
            "start" => $start,
            "end" => $end,
            "description" => (isset($obj->description)) ? $obj->description : 'N/A',
            "company" => (isset($obj->company)) ? $obj->company : 'N/A',
            "company_id" => (isset($obj->company_id)) ? $obj->company_id : 'N/A',
            "type" => (isset($obj->type)) ? $obj->type : 'N/A',
            "type_id" => (isset($obj->type_id)) ? $obj->type_id : 'N/A',
            "id" => $event->googleEvent->id,
            "accepted" => (isset($obj->accepted)) ? $obj->accepted : 0 ,
//            "private_user" => ($private_data !== null) ? (int) $private_data["user_id"] : null
        ];
    }

    public static function deleteEvent($id)
    {
        $event = CalendarController::getEvent($id);
        $desc = CalendarController::getEventDesc($event);
        if (($desc['user_id'] === Auth::user()->id && cp(13, Auth::user()->getPermissionIds())) || cp(14, Auth::user()->getPermissionIds())) {
//            dd('töröl');
            $event->delete();
            return redirect()->back();
        } else {
            return abort(403);
        }

    }

    /**
     * @author norbi
     * @return
     */
    public static function backupGoogleEvents(){
        dd(self::findAllEventOfYearData(2018, null));
        Log::useDailyFiles(storage_path().'/logs/debug.log');
        Log::info(json_encode(self::findAllEventOfYearData(2018, null)));
    }





}
