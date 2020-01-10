<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('first_player_id');
            $table->unsignedBigInteger('second_player_id')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->string('first_player_color');
            $table->string('second_player_color')->nullable();
            $table->boolean('started')->default(false);
            $table->boolean('finished')->default(false);
            $table->json('moves');
            $table->foreign('first_player_id')->references('id')->on('users');
            $table->foreign('second_player_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
