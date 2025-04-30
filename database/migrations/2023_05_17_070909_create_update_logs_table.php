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
        Schema::create('update_logs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('mã');
            $table->unsignedBigInteger('entity_id')->comment('id của bản ghi');
            $table->string('entity_type')->nullable()->comment('tên bảng');
            $table->string('columns')->comment('tên trường dữ liệu thay đổi');
            $table->string('old_data')->nullable()->comment('dữ liệu trước khi cập nhật');
            $table->string('new_data')->nullable()->comment('dữ liệu sau khi cập nhật');
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
        Schema::dropIfExists('update_logs');
    }
};
