<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_jp')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ro')->nullable();
            $table->string('photo_cover')->nullable();
            $table->string('photo_banner')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rating_mal', 4, 2)->nullable();
            $table->integer('rating_al')->nullable();
            $table->integer('rating')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->string('author')->nullable();
            $table->string('director')->nullable();
            $table->string('trailer')->nullable();
            $table->integer('episodes')->nullable();
            $table->string('category')->nullable();
            $table->integer('episodes_length')->nullable();
            $table->string('airing_status')->nullable();
            $table->string('season')->nullable();
            $table->string('animation_studio')->nullable();
            $table->string('title_zht')->nullable();
            $table->string('title_zhs')->nullable();
            $table->jsonb('genres')->nullable();
            $table->jsonb('tags')->nullable();
            $table->jsonb('sources')->nullable();
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
        Schema::dropIfExists('anime_temps');
    }
}
