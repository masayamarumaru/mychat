@extends('layouts.default')

@section('title', 'Edit User')

@section('header')
  <link href="/css/admin.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Remember to include jQuery :) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  <!-- jQuery Modal -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@endsection

@section('menu', 'ユーザー管理')

@section('header-btn')

@endsection

@section('content')
<a href="/admin">管理者メニュートップ</a>
<h2>ユーザー管理</h2>
<table border="1">
  <thread>
    <tr>
      <td>ユーザーid</td>
      <td>名前</td>
      <td>登録日</td>
      <td>参加ROOM</td>
    </tr>
    @forelse($users as $user)
      <tr>
        <form method="post" action="{{ action('AdminController@user_update', $user->id) }}">
          {{ csrf_field() }}
          {{ method_field('patch') }}
          <td>{{ $user->id }}</td>
          <td><input type="text" name="user_name" value="{{ old('name', $user->name) }}"></td>
          <td>{{ $user->created_at }}</td>
          <td class="join_user">{{ $user->rooms()->count() }}</td>
          <!-- <td class="join_user"><a href="#ex1" rel="modal:open">{{ $user->rooms()->count() }}</a></td> -->
          <td><input type="submit" value="更新"></td>
        </form>


        <form method="post" action="{{ action('AdminController@user_destroy', $user->id) }}">
          {{ csrf_field() }}
          {{ method_field('delete') }}
          <td><input type="submit" value="削除"></td>
        </form>

        <form class="user_chats" method="get" action="{{ action('AdminController@users_chat', $user->id) }}">
          {{ csrf_field() }}
          <input type="hidden" class="user_id" name="user_id" value="{{ $user->id }}">
          <td><input type="submit" value="投稿詳細"></td>
        </form>

      </tr>
    @empty
    @endforelse

</table>

@forelse($users as $user)
  <div id="ex1" class="modal">
    <h1>参加ルーム一覧</h1>
    <ul>
      @forelse($user->rooms as $room)
        <li>{{ $room->title }}</li>
      @empty
      @endforelse
    </ul>
    <!-- <a href="#" rel="modal:close">Close</a> -->
  </div>
@empty
@endforelse

@endsection

@section('ajax')
  <script>
    $(function() {

      $('.user_chats').submit(function(event) {
        event.preventDefault();
        var w = ( screen.width-640 ) / 2;
        var h = ( screen.height-480 ) / 2;
        var f = $(this.user_id).val();
          window.open("/admin/users_chat/"+f,"","width=750,height=480"+",left="+w+",top="+h);
      });

    });
  </script>
@endsection
