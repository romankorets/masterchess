@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Main menu</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="row justify-content-center">
                            <a class="btn btn-menu" href="{{route('game.create')}}">Create game</a>
                        </div>
                        <div class="row justify-content-center">
                            <a class="btn btn-menu" href="{{route('game.index')}}">List of games</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
