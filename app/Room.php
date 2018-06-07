<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;




class Room extends Model
{

    public function users() {
      return $this->belongsToMany('App\User');
    }

    public function chats() {
      return Room::hasMany('App\Chat')->orderBy('created_at', 'desc');
    }

    public function hasUser() {
      $user = Auth::user();
      foreach($this->users as $room_user) {
        if($room_user->id == $user->id) {
          return true;
        }
      }
      return false;
    }

    public function new_chats_count() {
      $user = Auth::user();
      $room_chats = $this->chats()->where('user_id', '!=', $user->id)->get();
// \Debugbar::startMeasure($this->title.'1');
      $user_reads =Readchat::where('user_id', $user->id)->get();
// \Debugbar::stopMeasure($this->title.'1');
// \Debugbar::startMeasure($this->title.'2');
      $new_chats = $room_chats->count();
// \Debugbar::stopMeasure($this->title.'2');
// \Debugbar::startMeasure($this->title.'3');
      foreach($room_chats as $chat){
        foreach($user_reads as $read){
          if($chat->id == $read->chat_id){
            $new_chats --;
            break;
          }
        }
      }
// \Debugbar::stopMeasure($this->title.'3');

      return $new_chats;
    }

}
