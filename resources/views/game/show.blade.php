@extends('layouts.app')

@section('content')
    <board-component game-Id="{{ $game->id }}" moves="{{ json_encode($game->moves) }}"></board-component>
@endsection
