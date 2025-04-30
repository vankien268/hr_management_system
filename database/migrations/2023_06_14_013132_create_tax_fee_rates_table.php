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
        Schema::create('tax_fee_rates', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->tinyInteger('type')->comment('Loại thuế phí')->comment('1 - phí, 0 - thuế');
            $table->tinyInteger('rate')->comment('Tỉ lệ');
            $table->string('description')->nullable()->comment('mô tả');
            $table->string('note')->nullable()->comment('ghi chú');
            $table->boolean('status')->default(1)->comment('1 - sử dụng, 0 - ngưng sd');
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
        Schema::dropIfExists('tax_fee_rates');
    }
};
