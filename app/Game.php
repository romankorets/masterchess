<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'first_player_id', 'second_player_id',
        'first_player_color', 'second_player_color', 'started', 'finished',
        'winner_id', 'moves'
    ];

    protected $casts = [
        'moves' => 'array'
    ];

    public function firstUser(){
        return $this->belongsTo(User::class, 'first_player_id');
    }

    public function secondUser(){
        return $this->belongsTo(User::class, 'second_player_id');
    }
}
