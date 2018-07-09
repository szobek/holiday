<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversations extends Model
{



    protected $table = "conversations";
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'title'
    ];



    public $appends = [
        'sender',
        'receiver',
    ];


    public function userConversations($uid){
        return $this->where('sender_id',$uid)->orWhere('receiver_id',$uid)->get();
    }


    public function messages(){
        return $this->hasMany('App\Messages', 'conversation_id', 'id');
    }

    /**
     * @author norbi
     * @return
     */
    public function getMessages(){
        $messages = $this->messages()->get();
        $message_list = [];
        foreach ($messages as $message) {
            $msg = new \stdClass();
            $msg->sender = [
                "name" => $message->sender->name,
                "id" => $message->sender->id,
            ];
            $msg->receiver = [
                "name" => $message->receiver->name,
                "id" => $message->receiver->id,
            ] ;
            $msg->content = $message->content;
            $msg->readed = $message->receiver_read;
            $msg->date = $message->created_at;
            $msg->by = ($message->sender->id === Auth::user()->id) ? 'sender' : 'receiver';
            $message_list[] = $msg;
        }
        return $message_list;
    }

    /**
     * @author norbi
     * @return
     */
    public static function createEmptyConversation(){
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
    public static function formatConversation($conversationParam, $getMessages = true) {
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

        if($getMessages) {
            $messages = $conversationParam->getMessages();
            $conversation->messages = $conversationParam->getMessages();
            $conversation->conversationData->messagesLength = count($messages);
        }
        else
            $conversation->conversationData->messagesLength = count($conversationParam->getMessages());


        return $conversation;
    }


    /**
     * @author norbi
     * @return
     */
    public function getSenderAttribute(){
        return $this->getSender()->first();
    }

    public function getReceiverAttribute(){
        return $this->getReceiver()->first();
    }


    public function getSender(){
        return $this->hasOne('App\User', 'id', 'sender_id');
    }

    public function getReceiver(){
        return $this->hasOne('App\User', 'id', 'receiver_id');
    }
}
