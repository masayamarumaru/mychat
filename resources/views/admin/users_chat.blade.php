<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>投稿詳細</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="/css/admin.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    <h1>投稿詳細</h1>

    ユーザー：{{ $user->name }}<br>
    投稿件数：{{ $user->chats()->count() }}<br>
    参加ROOM：<ul id="users_rooms">
                @forelse($user->rooms as $room)
                  <li>{{ $room->title }}</li>
                @empty
                @endforelse
            </ul>



  </body>
</html>
