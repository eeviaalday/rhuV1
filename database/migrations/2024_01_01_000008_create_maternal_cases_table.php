<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('maternal_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->date('lmp')->nullable();
            $table->date('edd')->nullable();
            $table->integer('gravida')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('living_children')->nullable();
            $table->text('supplements_issued')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maternal_cases');
    }
};
