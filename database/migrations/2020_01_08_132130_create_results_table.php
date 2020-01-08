<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("game_id");
            $table->bigInteger("winner_id")->nullable();
            $table->bigInteger("loser_id")->nullable();
            $table->boolean("isDraw");
            $table->foreign("game_id")->references("id")->on("games");
            $table->foreign("winner_id")->references("id")->on("users");
            $table->foreign("loser_id")->references("id")->on("users");

            $table->timestamps("createdAt");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
