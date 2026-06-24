<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('morbidity_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->string('diagnosis');
            $table->string('icd10_code')->nullable();
            $table->string('disease_category')->nullable();
            $table->string('severity')->nullable();
            $table->boolean('is_notifiable')->default(false);
            $table->enum('outcome', ['recovered', 'referred', 'deceased'])->nullable();
            $table->datetime('doh_submitted_at')->nullable();
            $table->datetime('locked_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('consultation_id')->references('id')->on('consultations')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('morbidity_records');
    }
};
