<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/styles.css">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- scss -->
    <link href="/css/style.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    <div class="container header">
      <h1>@yield('menu')</h1>
      <a class="home_btn" href="/chats">ホーム</a>
      @yield('header-btn')
      <span class="log_user">ログインユーザー：{{ Auth::user()->name }}</span>
    </div>
  <div class="container">
    @yield('content')
  </div>
   @yield('ajax')
</body>

</html>
