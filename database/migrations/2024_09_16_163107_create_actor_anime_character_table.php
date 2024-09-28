<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorAnimeCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_anime_character', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anime_id')->unsigned()->nullable();
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->integer('character_id')->unsigned()->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->integer('actor_id')->unsigned()->nullable();
            $table->foreign('actor_id')->references('id')->on('actors')->onDelete('cascade');
            $table->string('role')->nullable();
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
        Schema::dropIfExists('actor_anime_character');
    }
}
