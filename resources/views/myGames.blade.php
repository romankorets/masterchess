@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($gamesAsFirstPlayer) || $gamesAsSecondPlayer)
            <table class="table">
                <thead>
                <tr>
                    <th>Game ID</th>
                    <th>First player</th>
                    <th>Second player</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($gamesAsFirstPlayer as $game)
                    <tr>
                        <td>{{$game->id}}</td>
                        <td>{{$game->firstUser()->value('name')}}</td>
                        <td>{{$game->secondUser()->value('name')}}</td>
                        <td><a class="btn btn-primary" href="{{route('game.show', $game->id)}}">Continue</a></td>
                    </tr>
                @endforeach
                @foreach($gamesAsSecondPlayer as $game)
                    <tr>
                        <td>{{$game->id}}</td>
                        <td>{{$game->firstUser()->value('name')}}</td>
                        <td>{{$game->secondUser()->value('name')}}</td>
                        <td><a class="btn btn-primary" href="{{route('game.show', $game->id)}}">Continue</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
