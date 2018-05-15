@extends('layouts.default')

@section('title', 'ROOM作成')

@section('header')
<!-- js -->
<script src='../js/jQuery/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js'></script>
<script src='../js/jQuery/jquery-ui-1.9.2.custom/development-bundle/ui/minified/jquery-ui.custom.min.js'></script>
<script src='../js/jQuery/jquery-ui-multiselect-widget-master/src/jquery.multiselect.js'></script>
<script src='../js/jQuery/jquery-ui-multiselect-widget-master/demos/assets/prettify.js'></script>
<!-- css -->
<link rel="stylesheet" href='../js/jQuery/jquery-ui-1.9.2.custom/css/ui-lightness/jquery-ui-1.9.2.custom.min.css'>
<link rel="stylesheet" href='../js/jQuery/jquery-ui-multiselect-widget-master/jquery.multiselect.css'>
<link rel="stylesheet" href='../js/jQuery/jquery-ui-multiselect-widget-master/demos/assets/style.css'>
<link rel="stylesheet" href='../js/jQuery/jquery-ui-multiselect-widget-master/demos/assets/prettify.css'>


@endsection


@section('menu', 'ROOM　作成')

@section('content')
<h2>作成</h2>

<form method="post" action="{{ action('ChatsController@createroom') }}">
  タイトル
  <input type="text" name="room_name" placeholder="room title" value=''>
  @if ($errors->has('room_name'))
  <span class="error">{{ $errors->first('room_name') }}</span>
  @endif
  {{ csrf_field() }}

  <ul>
    <select class="user_select" size="2" multiple name="select_user[]">
      @forelse($users as $user)
        <option name="select_user[]" value="{{ $user->id }}">
          {{ $user->name }}
        </option>
      @empty
      @endforelse
    </select>

  </ul>
<!-- <ul>
@forelse($users as $user)
  <li>
    <input type="checkbox" name="select_user[]" value="{{ $user->id }}">
    {{ $user->name }}
  </li>
@empty
  <li>ユーザーがいません</li>
@endforelse
</ul> -->

  <input type="submit" value="Add">

</form>

@endsection
@section('ajax')

<script>
  jQuery(function($) {
    jQuery(".user_select").multiselect({
      selectedList: 100,
      checkAllText: "全選択",
      uncheckAllText: "全選択解除",
      noneSelectedText: "未選択です",
      selectedText: "# 個選択"
    });
  });
</script>

@endsection
