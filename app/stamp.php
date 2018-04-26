<?php

namespace App;
use App\Chat;

use Illuminate\Database\Eloquent\Model;

class stamp extends Model
{
    public function chats() {
      return $this->hasMany('App\Chat');
    }
}
