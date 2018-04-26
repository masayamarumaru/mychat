@extends('layouts.default')

@section('title', 'ROOM作成')

@section('menu', 'ROOM　作成')

@section('content')

<form method="post" action="{{ action('ChatsController@createroom') }}">

  <input type="text" name="room_name" placeholder="room title" value=''>
  @if ($errors->has('room_name'))
  <span class="error">{{ $errors->first('room_name') }}</span>
  @endif
  {{ csrf_field() }}
<ul>
@forelse($users as $user)
  <li>
    <input type="checkbox" name="select_user[]" value="{{ $user->id }}">
    {{ $user->name }}
  </li>
@empty
  <li>ユーザーがいません</li>
@endforelse
</ul>

  <input type="submit" value="Add">

</form>

@endsection
