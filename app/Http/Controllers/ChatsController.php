<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Room;
use App\Chat;
use App\Stamp;
use App\Config;
use Carbon\Carbon;
use App\Readchat;

class ChatsController extends Controller
{
    public function index() {
      $user = Auth::user();
      $rooms = Room::get();
      return view('chats.index')->with(['user' => $user, 'rooms' => $rooms]);
    }

    public function create() {
      $users = User::get();

      return view('chats.create')->with('users', $users);
    }

    public function createroom(PostRequest $request) {
      $room = new Room();
      $this->validate($request, [
        'room_name' => 'required'
      ]);

      $room->title = $request->room_name;
      $room->save();
      $room->users()->attach($request->select_user);

      return redirect('/chats');
    }


    public function edit(Room $room) {
      $user = Auth::user();
      $users = User::get();
      return view('chats.addmember')->with(['room' => $room, 'user' => $user, 'users' => $users]);
    }

    public function room(Room $room) {
      $user = Auth::user();
      $stamps = Stamp::get();
    // 時間取得
      $x = Config::get()->last();
      $config = $x->chats_disp;
      $now = Carbon::now();
    // 既読処理
      $reads = Readchat::where('user_id', $user->id)->get();
      $chats = $room->chats()->where('user_id', '!=', $user->id)->get();
      // dd($reads);
        foreach($chats as $chat) {
          $isMatch = false;
            foreach($reads as $read) {
                if($read->chat_id == $chat->id){
                  $isMatch = true;
                  break;
                }
              }
              if($isMatch == false) {
                $new_read = new Readchat();
                $new_read->user_id = $user->id;
                $new_read->chat_id = $chat->id;
                $new_read->save();
              }
          }

      return view('Chats.room')
            ->with(['room' => $room,
                    'user' => $user,
                    'stamps' => $stamps,
                    'config' => $config,
                    'now' => $now,
                    'reads' => $reads]);
    }


    public function update(PostRequest $request, Room $room) {
      $this->validate($request, [
        'title' => 'required'
      ]);

      $room->title = $request->title;
      $room->save();
      $room->users()->sync($request->select_user);

      return redirect('/chats');
    }

    public function destroy(Room $room) {
      $room->users()->detach();
      $room->chats()->delete();
      $room->delete();
      return redirect('/chats');
    }
}
