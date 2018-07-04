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
    public $dates;

    function __construct()
    {
        $this->users = [];
        $this->interactions = [];
        $this->dates = [];

    }

    /**
     * @author norbi
     * @return
     */
    public function checkinView(){
        if($_SERVER['SERVER_NAME'] !== config('app.disableCheckInUrl')) { // ha kívülről próbálják elérni, akkor 404
            $users = \App\User::all();
            return view('workhours/index', compact('users'));
        } else {
            abort(404);
        }
    }

    /**
     * felvisz egy sort az adatbázisba, elmenti a user beérkezés/távozás időpontját
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkIn(Request $request) {

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


    /**
     * kilistázza a usereket
     * @return $this
     */
    public function listAll() {
        $this->interactions = WorkHours::orderBy('created_at', 'asc')->get();
        $wh = $this->formatData();
        $this->search = 'MINDEN';
        $this->setThisDate();
        return $this->showList($wh);
//        return view('workhours/list/table', compact('wh'))->with(['search' => $this->search]);
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
                "day" => Carbon::parse($w->incoming)->format('Y-m-d'),
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
        $this->setThisDate($day);
        $this->search = "Választott nap: $day";
        return $this->showList($wh);
//        return view('workhours/list/table', compact('wh'))->with('search', $this->search);
    }



    public function getDateRangeInteractions($startDay, $endDay) {

        $start = Carbon::create(explode('-', $startDay)[0], explode('-', $startDay)[1] )->startOfMonth();
        $end = Carbon::create(explode('-', $startDay)[0], explode('-', $endDay)[1] )->startOfMonth();

        if($end < $start) {
            return "Not a valid date";
        };

        $this->interactions = WorkHours::whereBetween('created_at',[$start->startOfDay(), $end->endOfDay()])->get() ;
        $wh = $this->formatData();
        $this->setThisDate($startDay, $endDay);

        $this->search = $start->format('Y-m-d'). " - " . $end->format('Y-m-d');
        return $this->showList($wh);

    }


    public function getSingleUserInteractions(int $userId) {

        $this->interactions = WorkHours::where('user_id',$userId)->get() ;
        $wh = $this->formatData();
        $user = User::find($userId);
        $name = (!is_null($user)) ? $user->name : '';
        $this->search = "Felhasználó: $name";
        $this->setThisDate();

        return $this->showList($wh);
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

        return redirect()->to('/workhours');
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


        $user = User::find($request->user);
        if(!is_null($user)) {

            $start = Carbon::parse($request->incoming)->startOfDay();
            $end = Carbon::parse($request->incoming)->endOfDay();

            $row = WorkHours::where('user_id', $user->id)->whereBetween('incoming', array($start, $end))->orWhereBetween('outgoing', array($start, $end))->first();
            if(is_null($row)) {

                WorkHours::create([
                    "user_id" => $user->id,
                    "incoming" => $request->incoming,
                    "outgoing" => $request->outgoing,
                ]);


            } else {
                return response()->json(['success' => false, 'message' => 'sikertelen felvitel, már lett rögzítve ilyen sor']);

            }


        } else {
            return response()->json(['success' => false, 'message' => 'sikertelen felvitel, nincs ilyen user']);
        }

        return redirect()->to('/workhours');

    }


    /**
     * @author norbi
     * @return
     */
    public function setThisDate(string $date1 = null, string $date2 = null):void {
        if(is_null($date1)) $date1 = date('Y-m-d H:i:s');
        if(is_null($date2)) $date2 = date('Y-m-d H:i:s');

            //date('Y-m-d H:i:s')
        $this->dates = [
            "ys" => Carbon::parse($date1)->year,
            "ye" => Carbon::parse($date2)->year,
            "ms" => Carbon::parse($date1)->month,
            "me" => Carbon::parse($date2)->month,
        ];
    }


    /**
     * @param array $wh
     * @return $this
     */
    public function showList(array $wh){
        return view('workhours/list/table', compact('wh'))->with(['search' => $this->search, "dates" => $this->dates]);
    }



}
