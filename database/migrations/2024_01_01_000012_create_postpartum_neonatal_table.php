<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postpartum_neonatal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maternal_case_id');
            $table->string('delivery_outcome')->nullable();
            $table->string('baby_sex')->nullable();
            $table->string('delivery_type')->nullable();
            $table->boolean('amtsl_done')->default(false);
            $table->text('danger_signs')->nullable();
            $table->boolean('vitamin_k_given')->default(false);
            $table->string('newborn_screening_result')->nullable();
            $table->timestamps();

            $table->foreign('maternal_case_id')->references('id')->on('maternal_cases')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postpartum_neonatal');
    }
};
