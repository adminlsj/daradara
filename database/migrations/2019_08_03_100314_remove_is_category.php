<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Class RemoveIsCategory extends Migration
{
    public function up()
    {
        Schema::table('blogs', function($table) {
           $table->dropColumn('is_travel');
           $table->dropColumn('is_japan');
           $table->dropColumn('is_korea');
           $table->dropColumn('is_taiwan');
           $table->dropColumn('is_food');
           $table->dropColumn('is_fashion');
        });
    }

    public function down()
    {
        Schema::table('articles', function($table) {
           $table->boolean('is_travel');
           $table->boolean('is_japan');
           $table->boolean('is_korea');
           $table->boolean('is_taiwan');
           $table->boolean('is_food');
           $table->boolean('is_fashion');
        });
    }
}
