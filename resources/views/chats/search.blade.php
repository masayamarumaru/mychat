<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
    <div class="container">

      <h2>検索結果&emsp;『{{ $key }}』</h2>


        @forelse($chats as $chat)

          @forelse($chat->pns() as $pn)


            @if($pn)
              <li class="{{ $pn->stamp_id == null ? 'posted_chat':'posted_stamp' }}
                {{ $pn->user->id == $user->id ? 'login_user' :'guest_user' }}">


              @if($pn->stamp_id)
                <img src="{{ asset('/storage/img/sample2.png') }}" width="50px" height="50px">
              @else
                  {!! (nl2br(e($pn->body ))) !!}
              @endif
                <!-- <span class="user_info">
                  ({{ $pn->user->name }})
                  {{ $pn->created_at }}
                </span> -->

                <span class="user_info">
                  ({{ $chat->user->name }})
                    @if($now->diffInHours($chat->created_at) > 24)
                      {{ $chat->created_at->format('m月d日') }}
                    @else
                      {{ $now->diffInHours($chat->created_at) }}時間前
                    @endif
                </span>

              </li>
              <div style="clear:both"> </div>

            @else
            @endif

          @empty
          @endforelse
          <hr>
        @empty
        @endforelse

    </div>
  </body>
</html>
