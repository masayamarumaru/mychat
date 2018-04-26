<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>edit room</title>
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
<!-- img -->




  </head>
  <body>
    <h1>ROOM管理</h1>
    <a href="/admin">管理者メニュートップ</a>
      <form method="post" action="{{ action('AdminController@create_room') }}">
        <input type="text" name="room_name" placeholder="room title" value=''>
        @if ($errors->has('room_name'))
        <span class="error">{{ $errors->first('room_name') }}</span>
        @endif
        {{ csrf_field() }}
      <ul>
      @forelse($users as $user)
        <li>
          <input type="checkbox" name="user[]" value="{{ $user->id }}">
          {{ $user->name }}
        </li>
      @empty
        <li>ユーザーがいません</li>
      @endforelse
      </ul>
        <input type="submit" value="Add">
      </form>

      <table border="1">
        <thread>
          <tr>
            <td>ROOM id</td>
            <td>タイトル</td>
            <td>参加者</td>
          </tr>
        </thread>
        @forelse($rooms as $room)
          <tr>
            <form method="post" action="{{ action('AdminController@room_update', $room->id) }}">
              {{ csrf_field() }}
              {{ method_field('patch') }}
              <td>{{ $room->id }}</td>
              <td><input type="text" name="room_title" value="{{ old('title', $room->title) }}"></td>
              <td>
                <select class="user_select" size="2" multiple name="user[]">
                  @forelse($users as $user)
                    <option name="user[]" value="{{ $user->id }}" {{ $user->is_join_room($room->id) ? 'checked' :'' }} >
                      {{ $user->name }}
                    </option>
                  @empty
                  @endforelse
                </select>

                <!-- @forelse($users as $user)
                  <input type="checkbox" name="user[]" value="{{ $user->id }}" {{ $user->is_join_room($room->id) ? 'checked' :'' }} >
                  {{ $user->name }}
                @empty
                @endforelse -->


              </td>
              <td><input type="submit" value="更新"></td>
            </form>

            <form method="post" action="{{ action('AdminController@room_destroy', $room->id) }}">
              {{ csrf_field() }}
              {{ method_field('delete') }}
              <td><input type="submit" value="削除"></td>
            </form>

          </tr>
        @empty
        @endforelse
      </table>

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

  </body>
</html>
