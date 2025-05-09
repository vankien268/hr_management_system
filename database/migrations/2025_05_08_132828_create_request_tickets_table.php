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
        Schema::create('request_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('request_title')->nullable();
            $table->text('request_description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->float('number_leave_day')->nullable();
            $table->integer('approval_type')->nullable()->comment('Loại duyệt: 0 - Áp dụng cho tất cả, 1 - Thiết lập riêng');
            $table->integer('workflow_id')->nullable();
            $table->tinyInteger('request_status')->nullable()->comment('Trạng thái: 0 - Chờ duyệt, 1 - Đã duyệt, 2 - Đã từ chối, 3 - Đã hủy');
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
        Schema::dropIfExists('request_tickets');
    }
};
