@extends('layouts.app')

@section('content')
    <board-component game-Id-Php="{{ $game->id }}" moves-Php="{{ json_encode($game->moves) }}"
                     current-User-Id-Php="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                    first-Player-Id-Php="{{$game->first_player_id}}"
                    first-Player-Color-Php="{{$game->first_player_color}}"></board-component>
@endsection
