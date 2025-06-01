<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('salary_month')->nullable();
            $table->integer('salary_year')->nullable();
            $table->text('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_contacts');
    }
};
