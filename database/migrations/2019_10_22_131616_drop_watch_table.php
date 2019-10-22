<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropWatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('watch');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('watch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('genre');
            $table->string('category');
            $table->string('title');
            $table->text('imgur')->nullable();
            $table->timestamps();
        });
    }
}
