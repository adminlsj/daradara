<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anime_id')->unsigned()->nullable();
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->integer('animeable_id')->unsigned()->nullable();
            $table->string('animeable_type')->nullable();
            $table->string('relation')->nullable();
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
        Schema::dropIfExists('anime_relations');
    }
}
