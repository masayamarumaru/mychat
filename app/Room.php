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
      \Debugbar::startMeasure('sendMail');
      $user = Auth::user();
      $room_chats = $this->chats()->where('user_id', '!=', $user->id)->get();
      $user_reads =Readchat::where('user_id', $user->id)->get();
      $new_chats = $room_chats->count();

      foreach($room_chats as $chat){
        foreach($user_reads as $read){
          if($chat->id == $read->chat_id){
            $new_chats --;
            break;
          }
        }
      }
      \Debugbar::stopMeasure('sendMail');

      return $new_chats;
    }

}
