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
        Schema::create('deployment_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('mã lịch triển khai');
            $table->string('title')->comment('tiêu đề');
            $table->foreignId('project_id')->constrained()->comment('dự án');
            $table->foreignId('contract_type_id')->constrained()->comment('loại hợp đồng');
            $table->date('from_date')->comment('ngày bắt đầu');
            $table->date('to_date')->comment('ngày kết thúc');
            $table->string('note')->nullable()->comment('ghi chú');
            $table->text('project_content')->nullable()->comment('Nội dung dự án');
            $table->foreignId('status_id')->constrained('system_statuses')->comment('trạng thái loại lịch triển khai');
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
        Schema::dropIfExists('deployment_schedules');
    }
};
