<?php

use Illuminate\Database\Seeder;
use App\Room;
use App\User;
use App\Chat;

class RoomChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            // 全員参加のルーム作成
            $room = new Room([
                'title'=>'全員参加ルーム'
            ]);
            $room->save();

            // ルームに全ユーザを追加
            $users = User::all();
            $room->users()->attach($users);

            // 適当にそれぞれの発言したチャットを作成
            $chats = collect();
            foreach($users as $user) {
                $chat = new Chat([
                    'body' => $user->name . 'とは私のことです',
                    'user_id' => $user->id
                ]);
                $chats->push($chat);
            }
            $room->chats()->saveMany($chats);
        });
    }
}
