<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_zht')->nullable();
            $table->string('name_zhs')->nullable();
            $table->string('name_jp')->nullable();
            $table->string('name_en')->nullable();
            $table->jsonb('nicknames')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('hometown')->nullable();
            $table->string('blood_type')->nullable();
            $table->integer('height')->nullable();
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
        Schema::dropIfExists('actors');
    }
}
