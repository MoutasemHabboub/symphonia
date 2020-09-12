<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_specializations', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->unique();
            $table->foreign('specialization_id')->references('id')->on('specializations');
            $table->unsignedBigInteger('post_id')->unique();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->primary(['post_id', 'specialization_id']);
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
        Schema::dropIfExists('post_specializations');
    }
}
