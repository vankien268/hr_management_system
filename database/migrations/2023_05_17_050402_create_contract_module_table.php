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
        Schema::create('contract_module', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->comment('id hạng mục thực hiện');
            $table->foreignId('contract_id')->constrained()->comment('id hợp đồng');
            $table->bigInteger('value')->comment('giá trị theo hợp đồng');
            $table->string('note_module')->nullable()->comment('ghi chú');
            $table->boolean('status')->default(1)->comment('1 - sử dụng , 0 ngưng sd');
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
        Schema::dropIfExists('contract_modules');
    }
};
