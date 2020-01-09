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
            $table->bigInteger('first_player_id');
            $table->bigInteger('second_player_id')->nullable();
            $table->bigInteger('winner_id')->nullable();
            $table->string('first_player_color');
            $table->string('second_player_color')->nullable();
            $table->boolean('started')->default(false);
            $table->boolean('finished')->default(false);
            $table->json('moves')->default("{ 0 : rnbqkbnr/pppppppp/11111111/11111111/11111111/11111111/PPPPPPPP/RNBQKBNR w}");
            $table->timestamps('createdAt');
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
