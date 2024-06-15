<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToAnimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animes', function (Blueprint $table) {
            //description
            $table->string('category')->nullable();
            $table->integer('episodes_length')->nullable();
            $table->string('airing_status')->nullable();
            $table->string('season')->nullable();
            $table->dateTime('released_at')->nullable();
            $table->string('animation_studio')->nullable();
            $table->string('title_zht')->nullable();
            $table->string('title_zhs')->nullable();

            //episodes
            $table->string('episode_thumbnail')->nullable();
            $table->string('episode_name')->nullable();
            $table->dateTime('episode_release_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animes', function (Blueprint $table) {
            //
        });
    }
}
