<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourcesToBlogImgs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_imgs', function($table) {
            $table->text('thumbnail')->nullable();
            $table->text('original')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_imgs', function($table) {
           $table->dropColumn('thumbnail');
           $table->dropColumn('original');
        });
    }
}
