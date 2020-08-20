<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->foreign('id')->references('id')->on('users');
            $table->primary('id');           
            $table->string('phone_number');
            $table->string('address');
            $table->unsignedBigInteger('main_specialization');
            $table->foreign('main_specialization')->references('id')->on('specializations'); 
            $table->string('cv')->nullable();
            $table->boolean('gender')->default('0');
            $table->date('berthday');
            $table->integer('nationality')->unsigned();
            $table->boolean('Baccalaureate_type')->default('0');
            $table->integer('teaching_status')->unsigned()->nullable();
           

            $table->longText('fcm_token')->nullable();
            
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
        Schema::dropIfExists('teachers');
    }
}
