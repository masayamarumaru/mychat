<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if(!User::where('email','admin@example.com')->exists()) {
            User::create([
                'name' => "管理者 太郎",
                'email' => "admin@example.com",
                'password' => Hash::make("mychat"),
                'is_admin' => true,
            ]);
        }
        
        if(!User::where('email','user1@example.com')->exists()) {
            User::create([
                'name' => "鈴木　一郎",
                'email' => "user1@example.com",
                'password' => Hash::make("mychat"),
                'is_admin' => false,
            ]);
        }

        if(!User::where('email','user2@example.com')->exists()) {
            User::create([
                'name' => "ジョン・スミス",
                'email' => "user2@example.com",
                'password' => Hash::make("mychat"),
                'is_admin' => false,
            ]);
        }        
    }
}
