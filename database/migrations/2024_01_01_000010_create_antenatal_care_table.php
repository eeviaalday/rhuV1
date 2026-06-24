<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('antenatal_care', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prenatal_visit_id');
            $table->string('tetanus_toxoid')->nullable();
            $table->boolean('anti_helminthic')->default(false);
            $table->boolean('iron_folate')->default(false);
            $table->boolean('counseling_done')->default(false);
            $table->date('next_schedule')->nullable();
            $table->timestamps();

            $table->foreign('prenatal_visit_id')->references('id')->on('prenatal_visits')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('antenatal_care');
    }
};
