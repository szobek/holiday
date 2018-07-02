<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkHours;
use Carbon\Carbon;
use Illuminate\Http\Request;

class checkinController extends Controller
{
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
}
