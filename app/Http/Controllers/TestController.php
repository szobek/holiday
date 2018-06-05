<?php

namespace App\Http\Controllers;

use App\Mail\HolidayMaked;
use App\User;
use App\UserCompanies;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

	public static function hashing($userId, $password) {
		$user = User::find($userId);
		$user->password = Hash::make($password);
		$user->save();
		print "ok";
	}

	public static function parseKml() {
//	    $file = fopen(public_path('adm1.kml'), 'r');
        $xml=simplexml_load_file(public_path('adm1.kml'));
        $arr = [];
        foreach ($xml->Document->Placemark as $obj) {
            $name = $obj->name;
            $coordinates = $obj->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
            $coordString = str_replace("\n",' ', $coordinates);
            $temp = explode(' ',$coordString);
            $end = array_shift($temp);


            $arr[] = [
                "name" => $name,
                "coordinates" => (string)$coordinates
            ];

        }

        dd($arr);


    }

    /**
     * @author norbi
     * @return
     */
    public function testJson(){
        $url = "http://polygons.openstreetmap.fr/get_geojson.py?id=1447608&params=0";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);

        // Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        dd((json_decode($body)->geometries[0]->coordinates[0])[0]);
    }


    /**
     * @author norbi
     * @return
     */
    public function loginUseId(Request $request, $id){
//        if($_SERVER['SERVER_NAME'] === "localhost")
        if(Auth::user()->id === 1)
            Auth::loginUsingId($id);
        return redirect('/');
    }

    /**
     * @author norbi
     * @return
     */
    public function search(Request $request){


        $text = $request->text;
        $company_id = $request->company;

        $filter = User::where(function($query) use ($text) {
                $query->where('name','LIKE',"%$text")
                    ->orWhere('email', 'LIKE', "%$text%")
                    ->orWhere('telephone', 'LIKE', "%$text%");
            });

        if($company_id !== null && $company_id !== '')
            $filter->whereHas('getCompaniesArray', function ($q) use ($company_id) {
                $q->where('companies_id' , $company_id );
            });


        $result = $filter->get();
        $arr = [];
        foreach ($result as $item)
            $arr[] = $item;
        dd($arr);

    }



    public static function saveFile(Request $request) {

        $path = $request->file('image')->store(
            'upload/');
        return json_encode($path);

//        Storage::putFileAs('photos', new File('/upload'), 'photovalami.jpg');
    }


    /**
     * @author norbi
     * @return
     */
    public static function testEmail(){

        $mail = new HolidayMaked([]);
        $res = Mail::send($mail);
        dd($res);
    }


    public static function testWhere() {
        $users = User::where('id', '1')->orWhere('id', '>', 30)->get();
        dd($users);
    }




}
