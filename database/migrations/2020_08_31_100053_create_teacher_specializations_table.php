<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_specializations', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->unique();
            $table->foreign('specialization_id')->references('id')->on('specializations');
            $table->unsignedBigInteger('teacher_id')->unique();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->primary(['teacher_id', 'specialization_id']);
            $table->integer('teaching_phase')->unsigned();

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
        Schema::dropIfExists('teacher_specializations');
    }
}
