@extends('layouts.default')

@section('title', 'edit room')

@section('header')

@endsection

@section('menu', 'ファイルダウンロード')

@section('header-btn')

@endsection

@section('content')
  <a href="/admin">管理者メニュートップ</a>
  <h2>ダウンロード</h2>

  <div class="">
    <a href="/admin/file_create">Excel作成</a>
  </div>

@endsection

@section('ajax')

@endsection
