<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prenatal_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maternal_case_id');
            $table->date('visit_date');
            $table->string('weight')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('fundal_height')->nullable();
            $table->string('fetal_heart_rate')->nullable();
            $table->string('fetal_movement')->nullable();
            $table->string('age_of_gestation')->nullable();
            $table->string('presentation')->nullable();
            $table->string('edema')->nullable();
            $table->timestamps();

            $table->foreign('maternal_case_id')->references('id')->on('maternal_cases')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenatal_visits');
    }
};
