<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingAlCountToAnimeTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anime_temps', function (Blueprint $table) {
            $table->integer('rating_al_count')->nullable();
            $table->integer('favorites')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anime_temps', function (Blueprint $table) {
            //
        });
    }
}
