<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToCharacters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->integer('initial_age')->nullable();
            $table->integer('age')->nullable();
            $table->integer('height')->nullable();
            $table->jsonb('nickname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            //
        });
    }
}
