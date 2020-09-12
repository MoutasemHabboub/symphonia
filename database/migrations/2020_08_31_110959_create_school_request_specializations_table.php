<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolRequestSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_specializations', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->unique();
            $table->foreign('specialization_id')->references('id')->on('specializations');
            $table->unsignedBigInteger('request_id')->unique();
            $table->foreign('request_id')->references('id')->on('school_requests');
            $table->primary(['request_id', 'specialization_id']);
            $table->integer('study_phase')->unsigned()->nullable();
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
        Schema::dropIfExists('school_request_specializations');
    }
}
