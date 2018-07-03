<?php

namespace App\Http\Controllers;

use App\Companies;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class HolidayCountController extends Controller
{


    public function __construct()
    {

    }

    /**
     * @author norbi
     * @return
     */
    public function countUserHoliday($year, $id){
        $start = Carbon::create($year)->startOfYear();
        $end = Carbon::create($year)->endOfYear();

        $req = ["user_id=$id"];
        $events = Event::get($start, $end, ['privateExtendedProperty' => $req]);

        $eventRows = []; // ebbe kerül az eventek listája nap szerint bontva

        foreach ($events as $eventRow) {

            $desc = CalendarController::getPrivateData($eventRow);


            // a dátumok differenciája
            $diff = $desc['start']->diffInDays($desc['end']);
            $added = $desc['start']->copy();
            for($i = 0; $i<=$diff; $i++) {
                if($desc['type_id'] === '1') {
                    $eventRows[] = [
                        "type" => $desc['type_id'],
                        "date" => $added->toDatestring(),
                        "type_id" => $desc['type_id'],
                    ];
                }

                // növelem a dátumot
                $added = $added->copy()->addDay();
            }

        }

        return count($eventRows);

    }


}
