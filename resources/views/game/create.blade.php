@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-offset-4 col-md-4">
            <span>Choose your color</span>
            <form method="post" action="{{route('game.store')}}">
                {{ csrf_field() }}
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-dark">
                        <input type="radio" name="color" id="white" value="white" autocomplete="off">White
                    </label>
                    <label class="btn btn-dark">
                        <input type="radio" name="color" id="random" value="random" autocomplete="off">Random
                    </label>
                    <label class="btn btn-dark">
                        <input type="radio" name="color" id="black" value="black" autocomplete="off">Black
                    </label>
                </div>
                <p> <input type="submit" value="Submit" class="btn btn-success"></p>
            </form>
        </div>
    </div>
@endsection
