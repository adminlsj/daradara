<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedColumnsFromWatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('watches', function (Blueprint $table) {
            $table->dropColumn('genre');
            $table->dropColumn('category');
            $table->dropColumn('imgur');
            $table->dropColumn('cast');
            $table->dropColumn('season');
            $table->dropColumn('is_ended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('watches', function (Blueprint $table) {
            $table->string('genre')->nullable();
            $table->string('category')->nullable();
            $table->string('imgur')->nullable();
            $table->string('cast')->nullable();
            $table->string('season')->nullable();
            $table->boolean('is_ended')->nullable();
        });
    }
}
