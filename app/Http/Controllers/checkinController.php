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
        $type = $request->type;
        if(!is_null($user)) {

            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
            $row = WorkHours::where('user_id', $user->id)->where('type', $type)->whereBetween('created_at', array($start, $end))->first();
            if(is_null($row)) {
                WorkHours::create([
                    'user_id' => $user->id,
                    'type' => $type
                ]);
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
