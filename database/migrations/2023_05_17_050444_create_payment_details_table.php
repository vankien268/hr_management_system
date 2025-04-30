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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->comment('id hợp đồng');
            $table->integer('payment_times')->comment('số lần thanh toán');
            $table->bigInteger('amount')->comment('số tiền thanh toán');
            $table->bigInteger('actual_amount')->nullable()->comment('số tiền thanh toán thực tế');
            $table->date('expected_payment_date')->comment('ngày dự kiến thanh toán');
            $table->date('payment_date')->nullable()->comment('ngày thanh toán');
            $table->string('note')->nullable()->comment('ghi chú');
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
        Schema::dropIfExists('payment_details');
    }
};
