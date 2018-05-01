<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Stamp;
use App\User;
use App\Room;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Config;
use App\Chat;
use Excel;

class AdminController extends Controller
{
      public function index() {
        $user = Auth::user();
        if($user->is_admin){
        return view('admin.admin_index');
      }else{
        return view('admin.not_admin');
      }
    }

      public function stamp() {
        $stamps = Stamp::get();

        return view('admin.stamp')->with('stamps', $stamps);
      }

      public function create_stamp(Request $request) {
        $input = $request->all();
        $fileName = $input['fileName']->getClientOriginalName();
        $image = Image::make($input['fileName']->getRealPath());
        $image->save(public_path().'/storage/img/'.$fileName);

        $stamp = new Stamp();
        $stamp->stamp_path = $fileName;
        $stamp->save();

        return redirect('/admin/stamp');
      }

      public function destroy_stamp(Stamp $stamp, Request $request) {

        Storage::delete('public/img/'.$stamp->stamp_path);

        $stamp->delete();
        return redirect('/admin/stamp');
      }

      public function edit_user() {
        $users = User::get();
        return view('admin.edit_user')->with('users', $users);
      }

      public function user_destroy(User $user) {
        $user->delete();
        return redirect('/admin/users');
      }

      public function user_update(Request $request, User $user) {
        $user->name = $request->user_name;
        $user->save();
        return redirect('/admin/users');
      }


      public function edit_room() {
        $rooms = Room::get();
        $users = User::get();
        return view('admin.edit_room')->with(['rooms' => $rooms, 'users' => $users]);
      }

      public function room_destroy(Room $room) {
        $room->delete();
        return redirect('/admin/rooms');
      }

      public function room_update(Request $request, Room $room) {

        $room->title = $request->room_title;
        $room->save();
        $room->users()->sync($request->user);

        return redirect('/admin/rooms');
      }

      public function create_room(Request $request) {
        $room = new Room();

        $room->title = $request->room_name;
        $room->save();
        $room->users()->attach($request->user);

        return redirect('/admin/rooms');
      }

      public function users_chat(User $user) {

        return view('admin.users_chat')->with(['user' => $user]);
      }

      public function config() {
        return view('admin.config');
      }

      public function disp_change(Request $request) {
        $config = new Config();
        $config->chats_disp = $request->chats_disp;
        $config->chats_detail = $request->chats_detail;
        $config->save();

        return redirect('/admin/config');
      }

      public function file_down() {
        return view('admin.file_down');
      }

      public function file_create() {
        $chats = Chat::all();

        Excel::create('chats', function($excel) use($chats) {
          $excel->sheet('Sheet 1', function($sheet) use($chats) {
            $sheet->fromArray($chats);
          });
        })->export('xls');
      }

}
