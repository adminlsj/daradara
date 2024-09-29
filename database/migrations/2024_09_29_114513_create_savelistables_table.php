<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavelistablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savelistables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('savelist_id')->unsigned()->nullable();
            $table->foreign('savelist_id')->references('id')->on('savelists')->onDelete('cascade');
            $table->integer('savelistable_id')->unsigned()->nullable();
            $table->string('savelistable_type')->nullable();
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
        Schema::dropIfExists('savelistables');
    }
}
