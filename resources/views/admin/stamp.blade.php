<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>stamp</title>
  </head>
  <body>
    <h1>スタンプ作成</h1>
    <a href="/admin">管理者メニュートップ</a>

    {!! Form::open(['url' => '/admin/stamp/create', 'files' => true]) !!}
    {!! Form::label('fileName', 'スタンプ') !!}
    {!! Form::file('fileName') !!}
    {!! Form::submit('作成') !!}
    {!! Form::close() !!}

    <!-- <form method="post" action="{{ action('AdminController@create_stamp') }}">
      {{ csrf_field() }}
      <input type="file" name="stamp">
      <input type="submit" value="作成">
    </form> -->
        <table border="1" style="text-align: center;">
          <tr>
            @forelse($stamps as $stamp)
              <form method="post" action="{{ action('AdminController@destroy_stamp', $stamp->id) }}">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <td><img src="../storage/img/{{ $stamp->stamp_path }}" height="50px" width="50px"><br />
                <input type="submit" value="削除"></td>
              </form>
            @empty
            @endforelse
          </tr>
        </table>

    </ul>
  </body>
</html>
