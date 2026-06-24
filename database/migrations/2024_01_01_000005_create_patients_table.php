<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->date('birthdate');
            $table->string('sex');
            $table->string('blood_type')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->boolean('is_4ps')->default(false);
            $table->string('barangay');
            $table->string('province')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->string('archived_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
