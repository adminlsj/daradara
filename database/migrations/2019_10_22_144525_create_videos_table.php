<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->text('caption')->nullable();
            $table->text('tags')->nullable();
            $table->integer('current_views')->default(0);
            $table->integer('views');
            $table->string('imgur')->nullable();
            $table->text('sd')->nullable();
            $table->boolean('outsource')->nullable();
            $table->dateTime('uploaded_at')->nullable();
            $table->integer('playlist_id')->unsigned()->nullable();
            $table->foreign('playlist_id')->references('id')->on('watches')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->jsonb('foreign_sd')->nullable();
            $table->string('cover')->nullable();
            $table->jsonb('translations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
