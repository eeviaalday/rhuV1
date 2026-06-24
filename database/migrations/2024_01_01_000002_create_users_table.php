<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('designation')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('barangay')->nullable();
            $table->string('philhealth_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->datetime('last_login')->nullable();
            $table->datetime('last_password_change')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();

            $table->foreign('facility_id')->references('id')->on('facilities')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
