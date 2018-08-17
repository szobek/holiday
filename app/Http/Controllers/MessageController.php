<?php

namespace App\Http\Controllers;

use App\Conversations;
use App\Messages;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{


    public $conversations;
    public $conversation;
    public $sender;
    public $receiver;

    public function __construct()
    {
        $this->conversations = [];
        $this->conversation = new \stdClass();
    }

    /**
     * @author norbi
     * @return
     */
    public function getConversation(){

        return view('conversations/list');

    }

    /**
     * @author norbi
     * @return
     */
    public function apiGetConversations(){
        $c = new Conversations();
        $ca = $c->userConversations(Auth::user()->id); // összes beszélgetésem
        foreach ($ca as $cas) {
            $this->conversations[] = Conversations::formatConversation($cas, false);
        }
        return $this->conversations;
    }

    /**
     * @author norbi
     * @return
     */
    public function createConversationView(){
        $this->conversation = Conversations::createEmptyConversation();

        return view('conversations/detail')->with('conversation', $this->conversation)->with('users', User::all()->toArray());
    }

    public function createConversation(Request $request) {

//        dd($request->all());


        if(empty($request->receiver)) {
            dd('nincs címzett');
        }

        if(empty($request->title)) {
            dd('nincs title');
        }

        if(empty($request->msgContent)) {
            dd('nincs üzenet');
        }





        $data = new \stdClass();
        $data->sender = Auth::user()->id;
        $data->receiver = User::find($request->receiver);
        $data->content = $request->msgContent;
        $data->title = $request->title;


        if(is_null($data->receiver))
            dd('nincs ilyen user a címzettnél');



        $c = Conversations::create([
            "sender_id" => $data->sender,
            "receiver_id" => $data->receiver->id,
            "title" => $data->title
        ]);

        $m = Messages::create([
            'conversation_id' => $c->id,
            'sender_id' => $data->sender,
            'receiver_id' => $data->receiver->id,
            'receiver_read' => 0,
            'content' => $data->content,
        ]);

        return response()->json([
            'status' => true,
            'code' => 1,
            'data' => [
                'url' => "/message/".$c->id,
            ],

            ]);
//        return redirect()->to("message/".$c->id);
    }


    public function insertMessageToConversation(Request $request){

        $data = new \stdClass();
        $data->sender = Auth::user()->id;


        if(empty($request->msgContent)) {
            return redirect()->back();
        }
        $data->content = $request->msgContent;


        $data->cid = $request->cid;
        $data->conversation =Conversations::find($data->cid);


        if(is_null($data->conversation))
            return dd('nincs ilyen beszélgetés');

        if(is_null($data->conversation->receiver))
            return dd('nincs ilyen user');


        $m = Messages::create([
            'conversation_id' => $data->cid,
            'sender_id' => $data->sender,
            'receiver_id' => $data->conversation->receiver->id,
            'receiver_read' => 0,
            'content' => $data->content,
        ]);

        $conversationDb = Conversations::find($data->cid);
        $this->conversation = Conversations::formatConversation($conversationDb);
        return response()->json([
            'status' => true,
            'code' => 2,
            'data' => [
                'conversation' => $this->conversation
            ],

        ]);
//        return redirect()->back();
    }
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function getMessagesByConversationId($id){
        $conversation = Conversations::find($id);
        if(is_null($conversation))
            dd('nincs ilyen beszélgetés');

        return view('conversations/detail');

    }

    /**
     * lekéri egy adott beszélgetés üzeneteit
     * @author norbi
     * @return
     */
    public function getApiMessagesByConversationId($id){
//        dd('sdsd');
        $conversation = Conversations::find($id);
        if(is_null($conversation)) {
            return response()->json(['error' => 'Nincs ilyen beszélgetés']);
        }
        $this->setReadStatusOfMessage($id);
        $this->conversation = Conversations::formatConversation($conversation);
        return response()->json(['conversation' => $this->conversation]);
    }

    /**
     * beállítja az olvasott státuszt az üzenetnél
     * @author norbi
     * @return
     */
    public function setReadStatusOfMessage($id){
        Messages::where('conversation_id', $id)->update(['receiver_read' => 1]);
    }


    /**
     * @author norbi
     * @return
     */
    public function getApiUsers(){
        return response()->json(['users' => User::where('id','!=',Auth::user()->id)->get()->toArray()]);
    }

    /**
     * ellenőrzi, hogy érkezett-e új üzenet
     * @author norbi
     * @return
     */
    public function checkNewMessage(Request $request){
        $uid = $request->uid;
        return Messages::where('receiver_id', $uid)->where('receiver_read',0)->count();
    }



}
