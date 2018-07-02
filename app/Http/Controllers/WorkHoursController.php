<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkHours;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkHoursController extends Controller
{

    public $users;
    public $interactions;

    function __construct()
    {
        $this->users = [];
        $this->interactions = [];


    }

    /**
     * check user in exist user array
     * not call db, if exist
     * @param int $user
     * @return bool
     */
    function checkUserInArray(int $user): bool {
        $exists = false;
        foreach ($this->users as $singleUser) {
            if($singleUser->id === $user) {
                $exists = true;
                break;
            }

        }

        return $exists;
    }

    /**
     * get user from db without not required data
     * @param $id
     * @return User
     */
    function getUserData($id) {
        $user = User::find($id);
        if($user !== null) $user->setHidden(['company_list', 'permission_list', 'permission_list_ids','password', 'remember_token']);
        return $user;
    }

    /**
     * get user from usersArray, because if exist in array, not call db
     * @param int $userId
     * @return User
     */
    function getUserFromArray( int $userId): User {
        $user = null;

        foreach ($this->users as $singleUser) {
            if($singleUser->id === $userId) {
                $user = $singleUser;
                break;
            }

        }

        return $user;
    }

    function formatData() {
        $obj = [];
        foreach ($this->interactions as $w) {
            $user = ($this->checkUserInArray($w->user_id)) ? $this->getUserFromArray($w->user_id): $this->getUserData($w->user_id);
            if($user === null) continue; // ha nincs user, akkor tovább
            $obj[] = [
                "user" => $user,
                "user_id" => $user->id,
                "time" => Carbon::parse($w->created_at)->format('H:i:s'),
                "type" => $w->type,
                "day" => Carbon::parse($w->created_at)->format('Y-m-d')
            ];
        }
        return $obj;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->interactions = WorkHours::all();

        return dd($this->formatData());
    }

    /**
     *
     * @return boolean
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getSingleUserInteractions(int $userId) {

        $this->interactions = WorkHours::where('user_id',$userId)->get() ;
        return dd($this->formatData());
    }

    public function getSingleDayInteractions(string $day) {
        if(!strtotime($day)) {
            return "Not a valid date";
        }
        $start = Carbon::parse($day)->startOfDay();
        $end = Carbon::parse($day)->endOfDay();
        $this->interactions = WorkHours::whereBetween('created_at',[$start, $end])->get() ;
        return dd($this->formatData());
    }

    public function getDateRangeInteractions($startDay, $endDay) {
        $start = Carbon::parse($startDay)->startOfDay();
        $end = Carbon::parse($endDay)->endOfDay();


        dd(Carbon::parse($endDay) , Carbon::parse($startDay));

        if(Carbon::parse($endDay) > Carbon::parse($startDay)) {
            return "Not a valid date";
        };

        $this->interactions = WorkHours::whereBetween('created_at',[$start, $end])->get() ;
        return dd($this->formatData());
    }





}
