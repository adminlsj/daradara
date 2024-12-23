<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeCharacterRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_character_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anime_id')->unsigned()->nullable();
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->integer('character_id')->unsigned()->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
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
        Schema::dropIfExists('anime_character_roles');
    }
}
