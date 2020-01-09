@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($games))
        <table class="table">
            <thead>
                <tr>
                    <th>Game ID</th>
                    <th>Nickname</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr>
                        <td>{{$game->id}}</td>
                        <td>{{$game->first_player_id->name}}</td>
                        <td>{{$game->first_player_id->rating}}</td>
                        <td><a class="btn btn-primary" href="{{route('game.show', ['game', $game])}}">Play</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection
