@extends('layouts.default')

@section('title', 'Chat Room')

@section('menu', '管理者メニュー')


@section('header-btn')

@endsection

@section('content')
<a href="/admin">管理者メニュートップ</a>
<h2>メニュー</h2>
  <ol>
    <li>
      <a href="/admin/stamp">スタンプ追加</a>
    </li>
    <li>
      <a href="/admin/users">ユーザー管理</a>
    </li>
    <li>
      <a href="/admin/rooms">ルーム管理</a>
    </li>
    <li>
      <a href="/admin/config">各種設定</a>
    </li>
     <li>
       <a href="/admin/file_down">ファイルダウンロード</a>
     </li>
  </ol>
@endsection

@section('ajax')

@endsection
