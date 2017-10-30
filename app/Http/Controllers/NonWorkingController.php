<?php

namespace App\Http\Controllers;

use App\NonWorking;
use Illuminate\Http\Request;

class NonWorkingController extends Controller
{
    /**
     *
     *
     * @author norbi
     */
    public static function nonWorkingListView($year){
        $non_working = NonWorking::where('year', $year)->get();

        return view('nonworking.index', compact('non_working'));
    }
}
