<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_temps', function (Blueprint $table) {
            $table->bigIncrements('primary_id');
            $table->integer('id')->nullable();
            $table->integer('user_id')->nullable();;
            $table->string('name')->nullable();
            $table->string('route')->nullable();
            $table->index('route');
            $table->string('title')->nullable();
            $table->jsonb('translations')->nullable();
            $table->text('caption')->nullable();
            $table->string('cover')->nullable();
            $table->string('imgur')->nullable();
            $table->string('thumbL')->nullable();
            $table->string('thumbH')->nullable();
            $table->string('views')->nullable();
            $table->integer('duration')->nullable();
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
        Schema::dropIfExists('datas');
    }
}
