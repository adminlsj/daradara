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
            $table->integer('user_id');
            $table->integer('playlist_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('link');
            $table->string('imgur');
            $table->string('tags');
            $table->integer('views')->default(0);
            $table->boolean('outsource');
            $table->timestamps();
            $table->dateTime('uploaded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
