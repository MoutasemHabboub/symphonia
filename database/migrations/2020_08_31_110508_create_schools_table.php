<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->foreign('id')->references('id')->on('users');
            $table->primary('id');           
            $table->string('address');
            $table->string('name');
            $table->integer('students_gender')->unsigned();
            $table->integer('teaching_phase')->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
