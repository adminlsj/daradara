<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
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
            $table->decimal('height', 4, 1)->nullable();
            $table->text('description')->nullable();
            $table->string('photo_cover')->nullable();
            $table->jsonb('sources')->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
