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

}
