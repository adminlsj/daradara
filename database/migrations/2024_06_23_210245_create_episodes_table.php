<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anime_id')->unsigned();
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->string('episodes_thumbnail')->nullable();
            $table->string('title_zht')->nullable();
            $table->string('title_zhs')->nullable();
            $table->string('title_jp')->nullable();
            $table->dateTime('released_at')->nullable();
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
        Schema::dropIfExists('episodes');
    }
}
