<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBlogImgsRemoveAndAlter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_imgs', function (Blueprint $table) {
            $table->dropColumn('thumbnail');
            $table->dropColumn('minified');
            $table->renameColumn('original', 'imgur')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_imgs', function (Blueprint $table) {
            $table->text('thumbnail');
            $table->text('minified');
            $table->renameColumn('imgur', 'original')->change();
        });
    }
}
