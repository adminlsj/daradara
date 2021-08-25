<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('playlist_id')->unsigned()->nullable();
            $table->index('playlist_id');
            $table->integer('nhentai_id')->unsigned()->nullable();
            $table->index('nhentai_id');
            $table->integer('galleries_id')->unsigned()->nullable();
            $table->string('title_n_before')->nullable();
            $table->string('title_n_pretty')->nullable();
            $table->string('title_n_after')->nullable();
            $table->string('title_o_before')->nullable();
            $table->string('title_o_pretty')->nullable();
            $table->string('title_o_after')->nullable();
            $table->jsonb('parodies')->nullable();
            $table->jsonb('characters')->nullable();
            $table->jsonb('tags')->nullable();
            $table->jsonb('artists')->nullable();
            $table->jsonb('groups')->nullable();
            $table->jsonb('languages')->nullable();
            $table->jsonb('categories')->nullable();
            $table->integer('pages')->unsigned()->nullable();
            $table->string('extension')->nullable();
            $table->jsonb('extensions')->nullable();
            $table->integer('day_views')->default(0);
            $table->integer('week_views')->default(0);
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('comics');
    }
}
