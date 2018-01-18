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
        $years = NonWorking::select('year')->groupBy('year')->get()->pluck('year');

        $non_working = NonWorking::where('year', $year)->get();


        return view('nonworking.index', compact('non_working', 'years'));
    }

    /**
     *
     *
     * @author norbi
     */
    public function nonWorkingDetailView($id){
        if($id == "") return abort(404);
        $nwd = NonWorking::find($id);
        if($nwd ==( null)) return abort(404);

        return view('nonworking.detail', compact('nwd'));

    }

    /**
     *
     *
     * @author norbi
     * @return
     */
    public function nonWorkingDetail(Request $request){

        if($request->id == "") return abort(404);

        $nwd = NonWorking::find($request->id);
        if ($nwd == null) return abort(404);

        $nwd->name = $request->name;
        $nwd->year = $request->year;
        $nwd->date = $request->date;
        $nwd->description = $request->description;


        $nwd->save();

        return redirect()->to('nonworking');
    }

    /**
     *
     *
     * @author norbi
     * @return
     */
    public function nonWorkingCreateView(){

        return view('nonworking.detail');
    }

    /**
     *
     *
     * @author norbi
     */
    public function nonWorkingCreate(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|date|max:255',
            'description' => 'required|max:255',
            'year' => 'required|max:255',
        ]);

        $create = NonWorking::create($request->all());
        return redirect()->back();
    }




}
