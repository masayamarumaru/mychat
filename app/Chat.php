<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Config;
use App\Readchat;

class Chat extends Model
{
    public function room() {
      return $this->belongsTo('App\Room');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function stamp() {
      return $this->belongsTo('App\Stamp');
    }

    public function read() {
      return $this->belongsTo('App\Read');
    }

    public function read_count() {
      $read_count = Readchat::where('chat_id', $this->id)->count();
      return $read_count;
    }



    public function pns () {
      $x = Config::get()->first();

      $v = $x->chats_detail;
      $s = Chat::where('id', $this->id)->get();
      $prevs = Chat::where('id', '<', $this->id)->orderBy('created_at', 'desc')->limit($v)->get();
      $nexts = Chat::where('id', '>', $this->id)->orderBy('created_at', 'asc')->limit($v)->get();
      $pns = $prevs->merge($nexts)->merge($s)->sortByDesc('id');

      return $pns;
    }


}
