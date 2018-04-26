<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>config</title>


  </head>
  <body>
    <h1>各種設定</h1>
      <a href="/admin">管理者メニュートップ</a>

        <form action='{{ action('AdminController@disp_change') }}' method="post">
          {{ csrf_field() }}
          投稿表示件数<input type="number" name="chats_disp" value="" min="1" max="50">
          詳細前後表示件数<input type="number" name="chats_detail" value="" min="0" max="10">
          <input type="submit" value="変更">
        </form>


  </body>
</html>
