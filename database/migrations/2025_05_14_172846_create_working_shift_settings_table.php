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
        Schema::create('working_shift_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('shift_type')->nullable();
            $table->string('shift_title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->text('shift_weekdays')->nullable();
            $table->text('attributes')->nullable();
            $table->tinyInteger('valid')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_shift_settings');
    }
};
