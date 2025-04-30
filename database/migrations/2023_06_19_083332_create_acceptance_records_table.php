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
        Schema::create('acceptance_records', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title')->comment('tiêu đề');
            $table->foreignId('project_id')->constrained()->comment('dự án');
            $table->date('sent_date')->comment('ngày gửi');
            $table->date('acceptance_date')->comment(': ngày nghiệm thu');
            $table->string('sender')->nullable()->comment(': người gửi');
            $table->string('receiver')->nullable()->comment(': người nhận');
            $table->integer('warranty_period')->nullable()->comment('thời gian bải hành');
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
        Schema::dropIfExists('acceptance_records');
    }
};
