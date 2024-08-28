<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_character', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anime_id')->unsigned()->nullable();
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->integer('character_id')->unsigned()->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
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
        Schema::dropIfExists('anime_character');
    }
}
