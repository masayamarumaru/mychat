<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/styles.css">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <!-- scss -->
    <link href="/css/style.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    <div class="container header">
        <div class="header_style">
          <h1>@yield('menu')</h1>
          <img class="glass_icon" src="../img/glass_icon.svg" width="40px" height="40px">
          <!-- 検索 -->
          <div class="search_user wrapper">
            <div class="search-area">
              <form>
                <input type="text" id="search-text" placeholder="検索ワードを入力">
              </form>
              <div class="search-result">
                <div class="search-result__hit-num"></div>
                <div id="search-result__list"></div>
              </div>
            </div>
            <ul class="target-area">
              @forelse($global_users as $global_user)
              <li class="">
                <form name="user_id" method="get" action='{{ action('TalkController@indivi_room', $global_user->id) }}'>
                  {{ csrf_field() }}
                  @if($global_user->id !== $user->id)
                    <input type="hidden"><a href="/chats/indivi/{{ $global_user->id }}">{{ $global_user->name }}</a></input>
                  @endif
                </form>
              </li>
              @empty
              @endforelse
            </ul>
          </div>
          <!-- 検索 -->

        </div>
      <a class="home_btn" href="/chats">ホーム</a>
      @yield('header-btn')
      <span class="log_user">ログインユーザー：{{ Auth::user()->name }}</span>
    </div>

  <div class="container">
    @yield('content')
  </div>
   @yield('ajax')
   <script>
   // 検索

   // 検索
   </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>

</html>
