<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

//ログイン機能
// Route::get('/', function () {return view('welcome');});
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

//ログアウト
Route::group(array('before' => 'auth'), function() {
	Route::get('/account/sign-out', array(
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	));
});
Route::get('/home', 'HomeController@index')->name('home');

//チャット
Route::get('/chats', 'ChatsController@index');
Route::get('/chats/create', 'ChatsController@create');
Route::post('/chats/createroom', 'ChatsController@createroom');
Route::get('/chats/{room}', 'ChatsController@room')->where('room', '[0-9]+');;
Route::delete('/chats/{room}','ChatsController@destroy')->where('room', '[0-9]+');;
Route::get('/chats/{room}/edit', 'ChatsController@edit')->where('room', '[0-9]+');;
Route::patch('/chats/{room}', 'ChatsController@update')->where('room', '[0-9]+');;

//トーク
Route::get('/chats/{room}/search', 'TalkController@search_result');
Route::post('/chats/{room}/create', 'TalkController@ajax_post')->where('room', '[0-9]+');
//個人ROOM
Route::get('chats/indivi/{user}', 'TalkController@indivi_room');

//管理画面
Route::get('/admin', 'AdminController@index');
Route::get('/admin/stamp', 'AdminController@stamp');
Route::get('/admin/users', 'AdminController@edit_user');
Route::get('/admin/rooms', 'AdminController@edit_room');
Route::get('/admin/users_chat/{user}', 'AdminController@users_chat');
Route::get('/admin/config', 'AdminController@config');
Route::get('/admin/file_down', 'AdminController@file_down');
//スタンプ作成,削除
Route::post('/admin/stamp/create', 'AdminController@create_stamp');
Route::delete('/admin/stamp/{stamp}', 'AdminController@destroy_stamp');
//ユーザー管理
Route::delete('/admin/users/{user}', 'AdminController@user_destroy');
Route::patch('/admin/users/{user}', 'AdminController@user_update');
//ルーム管理
Route::delete('/admin/rooms/{room}', 'AdminController@room_destroy');
Route::patch('/admin/rooms/{room}', 'AdminController@room_update');
Route::post('/admin/rooms', 'AdminController@create_room');
//設定
Route::post('/admin/config/change', 'AdminController@disp_change');
//ファイルダウンロード
Route::get('/admin/file_create', 'AdminController@file_create');
