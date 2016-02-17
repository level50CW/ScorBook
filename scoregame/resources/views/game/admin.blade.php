@extends('layout.main')

@section('header')
    {!! Html::style('/css/admin.css') !!}
@stop

@section('content')
<h1>Todays Games</h1>

<div class="ui-view">
    <table class="ui-games">
        <tr>
            <th>Date Time</th>
            <th>Home</th>
            <th>Visitor</th>
            <th>Stadium</th>
            <th>Actions</th>
        </tr>
        @if ($games->count() == 0)
            <tr>
                <td colspan="5">No results found.</td>
            </tr>
        @else
            @foreach($games as $game)
                <tr>
                    <td>{!!\App\Helpers\LocalDateTime::fromCarbon($game->getDate())!!}</td>
                    <td>{{$game->teamHome->Name}}</td>
                    <td>{{$game->teamVisitor->Name}}</td>
                    <td>{{$game->location}}</td>
                    <td><a href="{{action('GameController@edit',$game->idgame)}}">
                            <img src="{{url('/images/admin/update.png')}}" alt="Update">
                        </a></td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
@stop