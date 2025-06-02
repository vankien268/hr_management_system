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
        Schema::create('request_ticket_results', function (Blueprint $table) {
            $table->id();
            $table->integer('request_ticket_id')->nullable();
            $table->string('result_type')->nullable();
            $table->dateTime('leave_day')->nullable();
            $table->integer('number_leave_day')->nullable();
            $table->integer('working_shift_id')->nullable();
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
        Schema::dropIfExists('request_ticket_results');
    }
};
