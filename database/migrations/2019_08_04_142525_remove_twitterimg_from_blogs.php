<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTwitterimgFromBlogs extends Migration
{
    public function up()
    {
        Schema::table('blogs', function($table) {
           $table->dropColumn('twitterimg');
        });
    }

    public function down()
    {
        Schema::table('blogs', function($table) {
           $table->text('twitterimg');
        });
    }
}
