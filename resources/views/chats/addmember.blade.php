@extends('layouts.default')

@section('title', 'ROOM作成')

@section('header')

@endsection

@section('menu', 'メンバー追加 ' . $room->title)

@section('content')

<form method="post" action="{{ action('ChatsController@update', $room->id) }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  <p>
    <input type="text" name="title" placeholder="enter title" value="{{ old('title', $room->title) }}">
    @if ($errors->has('title'))
    <span class="error">{{ $errors->first('title') }}</span>
    @endif
  </p>

  <p>
      @forelse($users as $user)
        <li>
          <input type="checkbox" name="select_user[]" value="{{ $user->id }}" {{ $user->is_join_room($room->id) ? 'checked' :'' }}>
          {{ $user->name }}
        </li>
      @empty
        <li>ユーザーいません</li>
      @endforelse
  </p>

  <p>
    <input type="submit" value="Update">
  </p>

</form>

@endsection

@section('ajax')

@endsection
