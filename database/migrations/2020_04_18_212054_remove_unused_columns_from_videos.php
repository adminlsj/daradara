<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedColumnsFromVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('genre');
            $table->dropColumn('category');
            $table->dropColumn('duration');
            $table->dropColumn('hd');
            $table->dropColumn('season');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('genre')->nullable();
            $table->string('category')->nullable();
            $table->integer('duration')->nullable();
            $table->text('hd')->nullable();
            $table->string('season')->nullable();
        });
    }
}
