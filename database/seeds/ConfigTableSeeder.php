<?php

use Illuminate\Database\Seeder;
use App\Config; // modelとしてのconfig
use App\Stamp; // modelとしてのconfig

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Config::create([
            'chats_disp' => 10, // チャット表示件数(ページネーション)
            'chats_detail' => 1 // チャット検索時、前後各取得件数
        ]);

        //
        Stamp::create([
            'stamp_path' => 'chabudai1.png'
        ]);
        Stamp::create([
            'stamp_path' => 'chabudai2.png'
        ]);
        Stamp::create([
            'stamp_path' => 'shacho1.png'
        ]);
    }
}
