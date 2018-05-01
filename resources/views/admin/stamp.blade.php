@extends('layouts.default')

@section('title', 'create stamp')

@section('menu', 'スタンプ作成')


@section('header-btn')

@endsection

@section('content')
<a href="/admin">管理者HOME</a>
<h2>作成・削除</h2>

    {!! Form::open(['url' => '/admin/stamp/create', 'files' => true]) !!}
    {!! Form::label('fileName', 'スタンプ') !!}
    {!! Form::file('fileName') !!}
    {!! Form::submit('作成') !!}
    {!! Form::close() !!}

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
@endsection
@section('ajax')

@endsection
