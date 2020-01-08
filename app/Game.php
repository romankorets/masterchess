<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const CREATED_AT = 'createdAt';

    protected $casts = [
        'moves' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class, "first_player_id");
    }
}
