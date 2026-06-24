<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('abdominal_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prenatal_visit_id');
            $table->string('trimester')->nullable();
            $table->string('fundic_height_cm')->nullable();
            $table->string('fetal_heart_tones')->nullable();
            $table->text('leopolds_maneuver')->nullable();
            $table->text('uterine_activity')->nullable();
            $table->timestamps();

            $table->foreign('prenatal_visit_id')->references('id')->on('prenatal_visits')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('abdominal_exams');
    }
};
