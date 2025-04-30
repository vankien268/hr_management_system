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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->string('allowance_name');
            $table->tinyInteger('allowance_type')->nullable()->comment('1: Loại cố định, 2: Loại tỉ lệ theo ngày công, 3: Loại nhập tay');
            $table->integer('allowed_number_days')->nullable()->comment('tên bộ phận');
            $table->string('allowance_amount')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('valid')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('default')->default(0)->comment('0: nhóm tự tạo, khác 0: nhóm mặc định gồm 1: phụ cấp ăn trưa, 2: xăng xe, 3: nuôi con nhỏ, 4: chuyên cần');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowances');
    }
};
