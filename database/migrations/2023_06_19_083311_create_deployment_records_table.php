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
        Schema::create('deployment_records', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title')->comment('tiêu đề');
            $table->foreignId('project_id')->constrained()->comment('dự án');
            $table->date('handover_date')->comment('ngày bàn giao');
            $table->string('handover_person')->nullable()->comment(': người bàn giao');
            $table->string('receiver')->nullable()->comment(': người nhận');
            $table->string('note')->nullable()->comment('ghi chú');
            $table->foreignId('status_id')->constrained('system_statuses');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployment_records');
    }
};
