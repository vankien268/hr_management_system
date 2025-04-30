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
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('mã công văn, thông báo');
            $table->string('number')->unique()->comment('số công văn, thông báo');
            $table->string('name')->comment('tên công văn, thông báo');
            $table->boolean('type')->comment('1 - Gửi đi, 0 - Tiếp nhận');
            $table->date('date')->nullable()->comment('ngày tháng');
            $table->foreignId('project_id')->constrained()->comment('dự án');
            $table->foreignId('customer_id')->constrained()->comment('khách hàng');
            $table->string('content', 1000)->nullable()->comment('nội dung');
            $table->string('sender')->nullable()->comment(': người gửi');
            $table->string('receiver')->nullable()->comment(': người nhận');
            $table->string('note')->nullable()->comment('ghi chú');
            $table->foreignId('status_id')->constrained('system_statuses');
            $table->date('from_date')->comment('ngày bắt đầu hiệu lực');
            $table->date('to_date')->comment('ngày kết thúc hiệu lực');
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
        Schema::dropIfExists('dispatches');
    }
};
