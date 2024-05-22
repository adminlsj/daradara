<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_ch');
            $table->string('title_jp');
            $table->string('title_en');
            $table->string('title_ro');
            $table->string('photo_cover');
            $table->string('photo_banner');
            $table->text('description');
            $table->decimal('rating_mal', 4, 2);
            $table->integer('rating_al');
            $table->integer('rating');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->string('author');
            $table->string('director');
            $table->string('trailer');
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
        Schema::dropIfExists('animes');
    }
}
