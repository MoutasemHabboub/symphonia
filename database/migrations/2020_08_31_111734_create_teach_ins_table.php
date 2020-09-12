<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teach_ins', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');       
            $table->unsignedBigInteger('teacher_id')->unique();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->primary(['teacher_id', 'school_id']);

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
        Schema::dropIfExists('teach_ins');
    }
}
