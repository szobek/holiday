<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\User;
use App\UserCompanies;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{

    private $user;
    private $holiday;
    private $startDate;
    private $toDate;

    function __construct()
    {
    }

    private function checkUserInDb() {
        if(!is_null($this->user))
            return Holiday::where('user_id', $this->user)->count();
        return false;
    }

    private function isHoliday() {
        if(!is_null($this->holiday))
            return Holiday::find(1) !== null;
        return false;
    }

    public static function checkValidDate($date) {

        $regex = (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date));
        if(!$regex)
            return false;
        return (Carbon::createFromFormat('Y-m-d', $date) );
    }

    public function collectDataToHoliday($user_id, $start_date, $to_date, $company_id) {

        $return_message = [
            "message" => "",
            "user" => "",
            "company" => false,
            "dates" => [
                "start" => "",
                "end" => "",
            ]
        ];

        $user = User::find($user_id);

        if($user === null) {
            $return_message["message"] .= 'Nincs ilyen user \r\n';
        } else {
            $return_message["user"] = $user;
        }

        $user_company = UserCompanies::where('user_id',$user_id)->where('companies_id',$company_id)->get();
        if($user_company !== null && count($user_company))
            $return_message['company'] = true;
        else
            $return_message["message"] .= 'Rossz cég a felhasználónál \r\n';


        if (HolidayController::checkValidDate($start_date)) {
            $return_message['dates']["start"] =Carbon::parse($start_date)->toDateString();
        } else {
            $return_message["message"] .= 'Rossz start dátum \r\n';
        }

        if (HolidayController::checkValidDate($to_date)) {
            $return_message['dates']["end"] =Carbon::parse($to_date)->toDateString();
        } else {
            $return_message["message"] .= 'Rossz végdátum \r\n';
        }

        if($return_message["dates"]["start"] > $return_message["dates"]["end"])
            $return_message["message"] .= 'Rossz dátumok (kisebb a kezdő dátum) \r\n';


        return $return_message;
    }

    public function checkUserAndHolidayConnect() {

    }

    public function checkHolidayExists($user_id, $google_id) {

//        return (Holiday::where('user_id',$user_id)->where('google_id', $google_id)->count());
    }

    public function createHoliday($user_id, $company_id, $start_date, $to_date, $type) {

        $data = HolidayController::collectDataToHoliday($user_id, $start_date, $to_date, $company_id);
        /*if($this->checkHolidayExists($user_id, $google_id)) {
            dd('van már ilyen id-val ');
        }*/


//        dd($data, $data["user"]->id, $data["dates"]["start"], $data["dates"]["end"], $type);


        DB::beginTransaction();
        try {
            $holiday = Holiday::create([
                "from_date" => $data["dates"]["start"],
                "to_date" => $data["dates"]["end"],
                "user_id" => $data["user"]->id,
                "type_id" => $type,
                "company_id" => $company_id,
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            Log::error('MessageController::sendMessage -- hiba ');
            Log::error($e);
            throw $e;
        }
    }


}
