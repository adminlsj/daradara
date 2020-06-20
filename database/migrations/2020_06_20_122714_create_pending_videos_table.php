<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('playlist_id');
            $table->string('title');
            $table->text('caption')->nullable();
            $table->string('tags');
            $table->integer('views')->default(0);
            $table->string('imgur')->nullable();
            $table->text('sd');
            $table->boolean('outsource')->nullable();
            $table->timestamps();
            $table->dateTime('uploaded_at')->nullable();
            $table->jsonb('foreign_sd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_videos');
    }
}
