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
        $c = new Conversations();
        $ca = $c->userConversations(Auth::user()->id); // összes beszélgetésem
        foreach ($ca as $cas) {
            $this->conversations[] = $this->formatConversation($cas);
        }

        return view('conversations/list')->with('conversation', $this->conversations);

    }
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function formatConversation($conversationParam) {
        $conversation = new \stdClass();
        $conversation->conversationData = new \stdClass();
        $conversation->conversationData->created = $conversationParam->created_at;
        $conversation->conversationData->id = $conversationParam->id;
        $conversation->conversationData->title = $conversationParam->title;
        $conversation->conversationData->sender = [
            "name" => $conversationParam->sender->name,
            "id" => $conversationParam->sender->id,
        ];
        $conversation->conversationData->receiver = [
            "name" => $conversationParam->receiver->name,
            "id" => $conversationParam->receiver->id,
        ];
        $conversation->messages = $conversationParam->getMessages();

        return $conversation;
    }

    /**
     * @author norbi
     * @return
     */
    public function createEmptyConversation(){
        $conversation = new \stdClass();
        $conversation->conversationData = new \stdClass();
        $conversation->conversationData->created = '';
        $conversation->conversationData->id = 0;
        $conversation->conversationData->sender = [
            "name" => '',
            "id" => '',
        ];
        $conversation->conversationData->receiver = [
            "name" => '',
            "id" => '',
        ];
        $conversation->messages = [];

        return $conversation;
    }

    /**
     * @author norbi
     * @return
     */
    public function createConversationView(){
        $this->conversation = $this->createEmptyConversation();
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
        $this->conversation = $this->formatConversation($conversation);

        return view('conversations/detail')->with('conversation', $this->conversation);


        
    }

}
