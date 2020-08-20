<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->foreign('specialization_id')->references('id')->on('specializations'); 


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
        Schema::dropIfExists('specializations');
    }
}
