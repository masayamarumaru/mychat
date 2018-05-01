@extends('layouts.default')

@section('title', 'Edit Config')

@section('header')

@endsection

@section('menu', '設定')

@section('header-btn')

@endsection

@section('content')
  <a href="/admin">管理者メニュートップ</a>
  <h2>設定</h2>
    <form action='{{ action('AdminController@disp_change') }}' method="post">
      {{ csrf_field() }}
      投稿表示件数<input type="number" name="chats_disp" value="" min="1" max="50">
      詳細前後表示件数<input type="number" name="chats_detail" value="" min="0" max="10">
      <input type="submit" value="変更">
    </form>
@endsection

@section('ajax')

@endsection
