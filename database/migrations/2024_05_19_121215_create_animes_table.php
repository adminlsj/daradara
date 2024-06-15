<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->bigIncrements('id');

            //headings
            $table->string('photo_banner')->nullable();
            $table->string('photo_cover')->nullable();
            $table->string('author')->nullable();
            $table->string('director')->nullable();

            //description
            $table->string('category')->nullable();
            $table->integer('episodes')->nullable();
            $table->integer('episodes_length')->nullable();
            $table->string('airing_status')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->string('season')->nullable();
            $table->dateTime('released_at')->nullable();
            $table->string('animation_studio')->nullable();
            $table->integer('rating')->nullable();
            $table->decimal('rating_mal', 4, 2)->nullable();
            $table->integer('rating_al')->nullable();
            $table->string('title_ch_trad')->nullable();
            $table->string('title_ch_simp')->nullable();
            $table->string('title_jp')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ro')->nullable();
            
            //overview
            $table->text('description')->nullable();
            $table->string('trailer')->nullable();
            $table->jsonb('sources')->nullable();

            //episodes
            $table->string('episode_thumbnail')->nullable();
            $table->string('episode_name')->nullable();
            $table->dateTime('episode_release_date')->nullable();

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
        Schema::dropIfExists('animes');
    }
}
