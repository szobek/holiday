<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkHours;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkinController extends Controller
{

    public $users;
    public $interactions;
    public $search;

    function __construct()
    {
        $this->users = [];
        $this->interactions = [];



    }

    public function createRow(Request $request) {


        $user = User::find($request->uid);
        $type = ($request->type === 'incoming') ? 'incoming' : 'outgoing' ;
        if(!is_null($user)) {

            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
            $row = WorkHours::where('user_id', $user->id)->whereNotNull($type)->whereBetween('created_at', array($start, $end))->first();
            if(is_null($row)) {

                $whrow = WorkHours::where('user_id', $user->id)->whereBetween('created_at', array($start, $end))->first();
                if(is_null($whrow)) { // ha még nincs felvíve sor
                    WorkHours::create([
                        $type => Carbon::now(),
                        "user_id" => $user->id
                    ]);
                } else {
                    $whrow->update([
                        $type => Carbon::now()
                    ]);
                }



                $typeString = ($type === 'incoming') ? 'Érkezés' : 'Távozás';
                return response()->json(['success' => true, 'message' => "sikeres felvitel, \r\n felhasználó: " .$user->name . ", \r\n interakció: $typeString"  ]);

            } else {
                return response()->json(['success' => false, 'message' => 'sikertelen felvitel, már lett rögzítve ilyen sor']);

            }


        } else {
            return response()->json(['success' => false, 'message' => 'sikertelen felvitel, nincs ilyen user']);
        }
    }

    public function listAll() {
        $this->interactions = WorkHours::orderBy('created_at', 'asc')->get();
        $wh = $this->formatData();
        $this->search = 'MINDEN';
        return view('workhours/list/table', compact('wh'))->with('search', $this->search);
    }


    function formatData() {
        $obj = [];
        foreach ($this->interactions as $w) {
            $user = ($this->checkUserInArray($w->user_id)) ? $this->getUserFromArray($w->user_id): $this->getUserData($w->user_id);
            if($user === null) continue; // ha nincs user, akkor tovább
            $incoming = new Carbon();
            $outgoing = new Carbon();
            $obj[] = [
                "user" => $user,
                "user_id" => $user->id,
                "incoming" => (is_null($w->incoming)) ? '' : $incoming::parse($w->incoming)->format('H:i:s'),
                "incomingDate" => (is_null($w->incoming)) ? '' : $incoming::parse($w->incoming)->format('Y-m-d H:i:s'),
                "outgoing" => (is_null($w->outgoing)) ? '' : $outgoing::parse($w->outgoing)->format('H:i:s'),
                "outgoingDate" => (is_null($w->outgoing)) ? '' : $outgoing::parse($w->outgoing)->format('Y-m-d H:i:s'),
                "day" => Carbon::parse($w->created_at)->format('Y-m-d'),
                "id" => $w->id
            ];
        }
        return $obj;
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


    public function getSingleDayInteractions(string $day) {
        if(!strtotime($day)) {
            return "Not a valid date";
        }
        $start = Carbon::parse($day)->startOfDay();
        $end = Carbon::parse($day)->endOfDay();
        $this->interactions = WorkHours::whereBetween('created_at',[$start, $end])->get() ;
        $wh = $this->formatData();
        $this->search = "Választott nap: $day";
        return view('workhours/list/table', compact('wh'))->with('search', $this->search);
    }



    public function getDateRangeInteractions($startDay, $endDay) {


        $start = new Carbon($startDay);
        $end = new Carbon($endDay);


//        dd($start ,$end);

        if($end < $start) {
            return "Not a valid date";
        };

        $this->interactions = WorkHours::whereBetween('created_at',[$start->startOfDay(), $end->endOfDay()])->get() ;
        $wh = $this->formatData();

        $this->search = "$startDay - $endDay";

        return view('workhours/list/table', compact('wh'))->with('search', $this->search);
    }


    public function getSingleUserInteractions(int $userId) {

        $this->interactions = WorkHours::where('user_id',$userId)->get() ;
        $wh = $this->formatData();
        $user = User::find($userId);
        $name = (!is_null($user)) ? $user->name : '';
        $this->search = "Felhasználó: $name";


        return view('workhours/list/table', compact('wh', 'search'))->with('search', $this->search);
    }

    /**
     * @author norbi
     * @return
     */
    public function updateView($id){

        if(!cp(18, Auth::user()->permissionList_ids)) {
            return redirect()->to('/');
        }
        $data = WorkHours::find($id);

        if(is_null($data)) {
            abort(404);
        }
        $this->interactions = [$data];
        $data = $this->formatData()[0];

        return view('workhours/update/update', compact('data'));
    }


    /**
     * @author norbi
     * @return
     */
    public function updateWorkhour(Request $request, $id){

        $wh = WorkHours::find($id);
        if(is_null($wh)) {
            abort(404);
        }
        $wh->update([
            "incoming" => $request->incoming,
            "outgoing" => $request->outgoing,
        ]);

        return redirect()->back();
    }

    /**
     * @author norbi
     * @return
     */
    public function deleteWorkhour(Request $request, $id){
        if(!cp(18, Auth::user()->permissionList_ids)) {
            return redirect()->to('/');
        }

        $wh = WorkHours::find($id);
        if(is_null($wh)) {
            abort(404);
        }

        $wh->delete();

        return redirect()->back();
    }


    /**
     * @author norbi
     * @return
     */
    public function createByAdminView()
    {
        if (!cp(18, Auth::user()->permissionList_ids)) {
            return redirect()->to('/');
        }

        $users = User::all();

        return view('workhours/create/create', compact('users'));
    }

    /**
     * @author norbi
     * @return
     */
    public function createByAdmin(Request $request){
        if(!cp(18, Auth::user()->permissionList_ids)) {
            return redirect()->to('/');
        }

//        dd($request->all());

        WorkHours::create([
            "user_id" => $request->user,
            "incoming" => $request->incoming,
            "outgoing" => $request->outgoing,
        ]);

        return redirect()->to('/workhours');

    }



}
