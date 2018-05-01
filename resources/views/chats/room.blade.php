@extends('layouts.default')

@section('title', 'ROOM作成')

@section('menu', 'TALK ' . $room->title)

@section('content')

<h2>投稿</h2>

<form id="ajax_post" method="post" action='{{ action('TalkController@ajax_post', $room) }}'>
  @if ($errors->has('body'))
  <span class="error">{{ $errors->first('body') }}</span>
  @endif
    {{ csrf_field() }}
    <p>
      <textarea class="chat_textarea" name="body" rows="4" cols="80" placeholder="enter post"></textarea>
    </p>
    <p>
      <input class="chat_submit" type="submit" value="投稿">
    </p>
      <div class="stamp_zone bootstrap">

          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" href="#collapse1">スタンプ</a></h4>
              </div>

                <div id="collapse1" class="panel-collapse collapse">
                  <div class="panel-body">
                    @forelse($stamps as $stamp)
                    <ul class="show_stamp1 ">
                      <li class="inline"><input class="show_stamp" type="image" name="s"
                         value="{{ $stamp->id }}" src="../storage/img/{{ $stamp->stamp_path }}" width="50" height="50"></li>
                    </ul>
                    @empty
                    スタンプがありません
                    @endforelse
                </div>
              </div>

            </div>
          </div>

      </div>
    <input id="stamp" type="hidden" name="stamp"></input>
</form>

<div class="talk_header">
<h2>TALK

  <form name="search_form" method="get" target="newtab" id="search_btn" action='{{ action('TalkController@search_result', $room) }}' class="search_form">
    <input type="text" id="search" name="key">
    <input type="submit" value="検索">
  </form>

</h2>
</div>

<ul class="new_post">

  @forelse ($room->chats()->paginate($config) as $chat)

    <li style="position:relative" class="a {{ $chat->stamp_id == null ? 'posted_chat':'posted_stamp' }}
      {{ $chat->user->id == $user->id ? 'login_user' :'guest_user' }} chat_list">
      @if($chat->stamp_id)
        <img src="../storage/img/{{ $chat->stamp->stamp_path }}" width="50px" height="50px">
      @else
      {!! (nl2br(e($chat->body))) !!}
      @endif
        <span class="user_info">
          ({{ $chat->user->name }})
            @if($now->diffInHours($chat->created_at) > 24)
              {{ $chat->created_at->format('m月d日') }}
            @else
              {{ $now->diffInHours($chat->created_at) }}時間前
            @endif
            <div>既読{{ $chat->read_count() }}</div>
        </span>

        <div class="reaction_box box-1">
          <form class="" method="post" action="{{ action('TalkController@delete_chat', $chat->id) }}">
            {{ csrf_field() }}
            {{ method_field('delete') }}
              <input class="chat_delete_btn" type="submit" value="X">
          </form>
        </div>
        <div class="reaction_box box-2">
          2
        </div>
        <div class="reaction_box box-3">

        </div>

    </li>
    <div style="clear:both"> </div>

  @empty
    <li></li>
  @endforelse
</ul>

<div class="bootstrap">
  {{ $room->chats()->paginate($config)->links('chats.bootstrap-4') }}
</div>
@endsection

@section('ajax')
  <script>
  //投稿リアルタイム更新
    $(document).on('click', '.show_stamp', function() {
      var r = $(this);
      $('#stamp').val(r.val());
    });

    $('#ajax_post').submit(function(event) {
      event.preventDefault();

      var $form = $(this);
      var $button = $form.find('button');

      $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serialize(),
        timeout: 1000,

        beforeSend: function(xhr, settings) {
          $button.attr('disabled', true);
        },
        complete: function(xhr, textStatus) {
          $button.attr('disabled', true);
        },

        success: function(result, textStatus, xhr) {
          //list追加処理
          if(result.body) {
            $('.new_post').prepend("<div></div>");
            $('.new_post > div').css('clear','both');
            $('.new_post').prepend("<li>"+result.body+"&nbsp;"+"</li>");
            $('.new_post li:first').addClass("posted_chat login_user");
            $('.new_post li:first').append("<span>"+"&nbsp;"+"("+result.post_user+")"+"&nbsp;"+"now"+"</span>");
            $('.new_post li:first span').addClass("user_info");

          } else {
            $('.new_post').prepend("<div></div>");
            $('.new_post > div').css('clear','both');
            $('.new_post').prepend("<li></li>");
            $('.new_post li').append("<img/>");
            $('.new_post li img:first').attr("src", "../storage/img/"+result.stamp_path);
            $('.new_post li img:first').attr('width', '50px').attr('height', '50px');
            $('.new_post li:first').addClass("posted_stamp login_user");
            $('.new_post li:first').append("<span>"+"&nbsp;"+"("+result.post_user+")"+"&nbsp;"+"&nbsp;"+"now"+"</span>");
            $('.new_post li:first span').addClass("user_info");
            $('#stamp').val('');  //hidden削除
          }

          $form[0].reset();
        },
        error: function(xhr, textStatus, error) {
          alert('NG...');
        }

      });
    });
//検索ウィンドウ
  $('#search_btn').submit(function(event) {
    event.preventDefault();
    var w = ( screen.width-640 ) / 2;
    var h = ( screen.height-480 ) / 2;
    var f = $('#search').val();
      window.open("{{ $room->id }}/search?search_key="+f,"","width=750,height=480"+",left="+w+",top="+h);

  });
// マウスオーバー
  $('.a').hover(
    function(){$(this).find('.reaction_box').addClass('b');},
    function(){$(this).find('.reaction_box').removeClass('b');}
  );

  </script>
@endsection
