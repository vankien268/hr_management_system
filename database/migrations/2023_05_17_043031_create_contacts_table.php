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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('tên người liên hệ');
            $table->string('email')->comment('email người liên hệ');
            $table->string('phone')->comment('số điện thoại liên hệ');
            $table->string('position')->comment('chức vụ');
            $table->string('note')->nullable()->comment('mã số thuế');
            $table->foreignId('customer_id')->constrained()->comment('id khách hàng');
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
        Schema::dropIfExists('contacts');
    }
};
