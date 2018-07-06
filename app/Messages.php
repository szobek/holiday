<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{


    protected $table = "conversations_messages";
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'receiver_read',
        'content',
    ];


    /**
     * @author norbi
     * @return
     */
    public function userMessages($cid){
        return $this->where('conversation_id',$cid)->get();
    }

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
