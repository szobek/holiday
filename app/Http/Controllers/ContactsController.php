<?php

namespace App\Http\Controllers;

use App\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public $contacts;

    public function __construct()
    {
        $this->contacts = [];
    }

    /**
     * @author norbi
     * @return
     */
    public function getUserContacts($uid)
    {
        $c = new Contacts();
        $this->contacts = $c->getUserContacts($uid);
        return $this->contacts;
    }

    public function apiCreateContact(Request $request)
    {


        $names = [
            'Michael',
            'Joshua',
            'Matthew',
            'Christopher',
            'Andrew',
            'Daniel',
            'Ethan',
            'Joseph',
            'William',
            'Steven',
            'Chase',
            'Timothy',
            'Jeremiah',
            'Sebastian',
            'Xavier',
            'Devin',
            'Cody',
            'Seth',
            'Hayden',
            'Blake',
            'Richard',
            ];

        $name = $names[rand(0,count($names)-1)] . ' ' . $names[rand(0,count($names)-1)];

        Contacts::create([
            'user_id' => Auth::user()->id,
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_name' => $request->contact_name,

        ]);

        return response()->json(['status' => true, 'data' => ['message' => 'sikeres']]);
    }


    /**
     * @author norbi
     * @return
     */
    public function apiGetContacts(){
        return response()->json(['contacts' => $this->getUserContacts(Auth::user()->id)]);
//        return response()->json(['status' => true, 'data' => ['contacts' => $this->getUserContacts(Auth::user()->id)]]);
    }


    /**
     * @author norbi
     * @return
     */
    public function indexView(){
        return view('contacts/master');
    }
}
