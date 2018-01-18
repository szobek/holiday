<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public static function setEventName($name){
        return "Szabadság - $name";
    }

    /**
     * Készít egy egész napos eventet a naptárba
     * @param $obj array {name: 'ez a név', start: '2017-10-10', end: '2017-10-10', description: 'ez egy szabadság...'}
     * @return Event
     */
    public static function createFulldayEvent($obj) {
        $event = new Event;
        $event->name = self::setEventName($obj["name"]);
        $event->description = json_encode($obj);
        $event->__set('start.date',Carbon::parse($obj["start"])->setTimezone('Europe/Budapest') );
        $event->__set('end.date',Carbon::parse($obj["end"])->addDay(1)->setTimezone('Europe/Budapest') );
        $event->save();

        return $event;
    }

    /**
     *
     *
     * @author norbi
     * @return boolean
     */
    public static function updateFulldayEvent($request){


        $event = CalendarController::getEvent($request['id']);


        $event->__set('start.date',Carbon::parse($request["start"])->setTimezone('Europe/Budapest') );
        $event->__set('end.date',Carbon::parse($request["end"])->addDay(1)->setTimezone('Europe/Budapest') );


        $desc = json_decode($event->googleEvent->description);
        $desc->start = Carbon::parse($request["start"]);
        $desc->end = Carbon::parse($request["end"]);
        $desc->description = $request["description"];
        $desc->type = $request->type;
        $desc->type_id = $request->type_id;

        $event->__set('description', json_encode($desc) );
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
    public static function getEvent($id = null){
        return ($id !== null) ? Event::find($id) : null ;
    }


    public static function findAllEventOfYearData($year, $month = null){


        if(!isset($month) || $month === null) {
            $monthStart = 1;
            $monthEnd = 12;
        } else {
            $monthStart = $month;
            $monthEnd = $month;
        }
        $start = Carbon::create($year,$monthStart,1, 0,0,0);
        $end = Carbon::create($year,$monthEnd,31, 23,59,59);

        $parameters = [
            "timeMin" => Carbon::parse($start)->format(config('google-calendar.format')),
            "timeMax" => Carbon::parse($end)->format(config('google-calendar.format')),
        ];

        $events = Event::get(null,null,$parameters);


        $returned = [];

        $perm_own_company =  cp(6, Auth::user()->permission_listIds); // csak a saját cégeinek a szabadsága
        $perm_all_company =  cp(2, Auth::user()->permission_listIds); // minden szabadságot lát

        foreach ($events as $event) {
            $return_event = self::getEventDesc($event);
            if($perm_all_company) {
                $returned[] = $return_event;
            } else if($perm_own_company) {
                $ids = Auth::user()->company_list->pluck('id')->toArray();
                if(in_array($return_event['company_id'], $ids)) {
                    $returned[] = $return_event;
                }
            } else {

            }


        }


        return $returned;
    }

    public static function getEventDesc($event){

        $obj = json_decode($event->googleEvent->description);
        $start = Carbon::parse($event->googleEvent->getStart()->date);
        $end = Carbon::parse($event->googleEvent->getEnd()->date)->subDay(1);
        return [
            "name" => (isset($obj->name)) ? $obj->name : 'N/A' ,
            "user_id" => (isset($obj->user_id)) ? $obj->user_id : 'N/A',
            "start" => $start,
            "end" => $end,
            "description" => (isset($obj->description)) ? $obj->description : 'N/A',
            "company" => (isset($obj->company)) ? $obj->company : 'N/A',
            "company_id" => (isset($obj->company_id)) ? $obj->company_id: 'N/A',
            "type" => (isset($obj->type)) ? $obj->type : 'N/A',
            "type_id" => (isset($obj->type_id)) ? $obj->type_id : 'N/A',
            "id" => $event->googleEvent->id,
        ];
    }

    public static function deleteEvent($id){
        $event = CalendarController::getEvent($id);
        $event->delete();
        return redirect()->back();
    }



}
