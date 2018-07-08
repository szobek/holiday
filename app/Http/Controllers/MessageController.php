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
            $this->conversations[] = Conversations::formatConversation($cas);
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
        $data = new \stdClass();
        $data->sender = Auth::user()->id;
        $data->receiver = User::find($request->receiver);
        $data->content = $request->msgContent;


        if(is_null($data->receiver))
            return abort(404);

        $c = Conversations::create([
            "sender_id" => $data->sender,
            "receiver_id" => $data->receiver->id,
            "title" => $request->title
        ]);

        $m = Messages::create([
            'conversation_id' => $c->id,
            'sender_id' => $data->sender,
            'receiver_id' => $data->receiver->id,
            'receiver_read' => 0,
            'content' => $data->content,
        ]);

        return redirect()->to("message/".$c->id);
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

        return redirect()->back();
    }
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function getMessagesByConversationId($id){
        $conversation = Conversations::find($id);
        if(is_null($conversation))
            dd('nincs ilyen beszélgetés');
        $this->conversation = Conversations::formatConversation($conversation);

        return view('conversations/detail')->with('conversation', $this->conversation);

    }

}
