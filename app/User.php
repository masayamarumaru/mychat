<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'stamp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rooms() {
      return $this->belongsToMany('App\Room');
    }

    public function chats() {
      return $this->hasMany('App\Chat');
    }

    public function read() {
      return $this->belongsTo('App\Read');
    }

    public function is_join_room($room_id) {

      foreach($this->rooms as $room) {
        if($room->id == $room_id ) {
          return true;
        }
      }
      return false;
    }

}
