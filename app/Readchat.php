<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Readchat extends Model
{
  public function users() {
    return $this->hasMany('App\User');
  }

  public function chats() {
    return $this->hasMany('App\Chat');
  }
}
