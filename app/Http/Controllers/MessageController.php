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

        dd( $this->conversations);

    }
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function formatConversation($conversationParam) {
        $conversation = new \stdClass();
        $conversation->conversationData = new \stdClass();
        $conversation->conversationData->created = $conversationParam->created_at;
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


    public function createConversation(Request $request) {

        $data = new \stdClass();
        $data->sender = Auth::user()->id;
        $data->receiver = User::find($request->receiver);
        $data->content = $request->msgContent;


        if(is_null($data->receiver))
            return abort(404);

        $c = Conversations::create([
            "sender_id" => $data->sender,
            "receiver_id" => $data->receiver->id
        ]);

        $m = Messages::create([
            'conversation_id' => $c->id,
            'sender_id' => $data->sender,
            'receiver_id' => $data->receiver->id,
            'receiver_read' => 0,
            'content' => $data->content,
        ]);
    }


    public function insertMessageToConversation(Request $request){

        $data = new \stdClass();
        $data->sender = Auth::user()->id;
        $data->receiver = User::find($request->receiver);
        $data->content = $request->msgContent;
        $data->cid = $request->cid;
        $data->conversation =Conversations::find($data->cid);

        if(is_null($data->conversation))
            return dd('nincs ilyen beszélgetés');

        if(is_null($data->receiver))
            return dd('nincs ilyen user');
//            return abort(404, 'Nincs ilyen user');

        if($data->conversation->sender_id !== $data->receiver->id && $data->conversation->receiver_id !== $data->receiver->id)
            return dd( 'Hibás user');

        $m = Messages::create([
            'conversation_id' => $data->cid,
            'sender_id' => $data->sender,
            'receiver_id' => $data->receiver->id,
            'receiver_read' => 0,
            'content' => $data->content,
        ]);

    }
    
    
    /** 
     * @author norbi
     * @return 
     */
    public function getMessagesByConversationId(Request $request){
        $conversation = Conversations::find($request->cid);
        if(is_null($conversation))
            dd('nincs ilyen beszélgetés');
        $this->conversation = $this->formatConversation($conversation);

        
        
    }

}
