<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('wechat')->nullable();
            $table->string('qq')->nullable();
            $table->string('edu_title')->nullable();
            $table->string('edu_gpa')->nullable();
            $table->string('edu_university')->nullable();
            $table->string('edu_start')->nullable();
            $table->string('edu_end')->nullable();
            $table->string('work_title')->nullable();
            $table->string('work_company')->nullable();
            $table->string('work_start')->nullable();
            $table->string('work_end')->nullable();
            $table->text('work_description')->nullable();
            $table->string('language_one')->nullable();
            $table->string('language_one_level')->nullable();
            $table->string('language_two')->nullable();
            $table->string('language_two_level')->nullable();
            $table->string('language_three')->nullable();
            $table->string('language_three_level')->nullable();
            $table->text('other_description')->nullable();
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
        Schema::dropIfExists('resumes');
    }
}
