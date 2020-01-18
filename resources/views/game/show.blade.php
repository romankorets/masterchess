@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <board-component game-Id-Php="{{ $game->id }}" moves-Php="{{ json_encode($game->moves) }}"
                                                                 current-User-Id-Php="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                                                                 first-Player-Id-Php="{{$game->first_player_id}}"
                                                                 first-Player-Color-Php="{{$game->first_player_color}}">

            </board-component>
        </div>

    </div>
@endsection
