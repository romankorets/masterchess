@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="row justify-content-center">
                <div class="color_piker col-md-8">
                    <div class="row justify-content-center">
                        <span>Choose your color</span>
                    </div>
                    <div class="row justify-content-center">
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
                            <div class="row justify-content-center">
                                <input type="submit" value="Submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection
