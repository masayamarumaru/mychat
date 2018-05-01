<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Room;
use App\Chat;
use Carbon\Carbon;
use App\UserRoom;

class TalkController extends Controller
{
    public function post(PostRequest $request, Room $room) {

      // dd($request->stamp);

      $chats = new Chat();
      $user = Auth::user();

      if($request->stamp) {
        $chats->stamp_id = $request->stamp;
        $chats->user_id = $user->id;
        $chats->room_id = $room->id;
        $chats->save();
      }else{
        $this->validate($request, [
          'body' => 'required'
      ]);
        $chats->body = $request->body;
        $chats->user_id = $user->id;
        $chats->room_id = $room->id;
        $chats->save();
    }

    // return $chats;
      return redirect()->action('ChatsController@room', $room);
    }

    public function ajax_post(PostRequest $request, Room $room) {
      $chats = new Chat();
      $user = Auth::user();

      if($request->stamp) {
        $chats->stamp_id = $request->stamp;
        $chats->user_id = $user->id;
        $chats->room_id = $room->id;
        $chats->save();
        $chats->stamp_path = $chats->stamp->stamp_path;
      }else{
        $this->validate($request, [
          'body' => 'required'
      ]);
        $chats->body = $request->body;
        $chats->user_id = $user->id;
        $chats->room_id = $room->id;
        $chats->save();
      }

      $chats->post_user = $user->name;
      return $chats;
    }

  public function search_result(Request $request ,Room $room) {
    $user = Auth::user();

    $key = $request->search_key;
    $chats = Chat::where('body', 'LIKE', "%$key%")
                  ->where('room_id', $room->id)
                  ->get();

    // 時間取得
    $now = Carbon::now();

    return view('chats.search')->with(['chats' => $chats,
                                        'key' => $key,
                                        'user' => $user,
                                        'now' => $now]);
  }

  public function indivi_room(User $user) {
    $now_user = Auth::user();
    $rooms = Room::get();
    foreach($rooms as $room){
      if($room->users()->count() === 2){
        if($room->users->contains($user->id) && $room->users->contains($now_user->id)){
            return redirect('/chats/'.$room->id);
          }
      }
    }
    $new_room = new Room();
    $new_room->title = $user->name.'と'.$now_user->name.'のROOM';
    $new_room->save();
    $new_room->users()->attach(array($user->id,$now_user->id));
    $create_room = $rooms->sortByDesc('id')->first();
    return redirect('/chats/'.$create_room->id);
  }

  public function delete_chat(Chat $chat) {
    $chat->delete();
    return redirect()->back();
  }

}
