<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('first_user_id');
            $table->bigInteger('second_user_id');
            $table->string('name');
            $table->string('first_user_color')->default('white');
            $table->string('second_user_color')->default('black');
            $table->timestamps();
            $table->foreign('first_user_id')->references('id')->on('users');
            $table->foreign('second_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_games');
    }
}
