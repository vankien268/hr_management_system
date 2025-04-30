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
        Schema::create('system_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('tên trạng thái');
            $table->string('note')->nullable()->comment('ghi chú - diễn giải');
            $table->tinyInteger('type')->comment('phân loại: 0 - dự án, 1- hợp đồng, 2- khách hàng, 3- nhật kí dự án');
            $table->boolean('status')->default(1)->comment('1- sử dụng, 0-ngưng sd');
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
        Schema::dropIfExists('system_statuses');
    }
};
