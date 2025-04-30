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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('mã khách hàng');
            $table->string('name')->comment('tên khách hàng');
            $table->string('tax_code')->nullable()->comment('mã số thuế');
            $table->string('address')->nullable()->comment('địa chỉ');
            $table->foreignId('user_id')->constrained()->comment('người phụ trách')->nullable();
            $table->foreignId('city_id')->nullable()->constrained()->comment('id tỉnh/thành phố');
            $table->foreignId('district_id')->nullable()->constrained()->comment('id quận/huyện');
            $table->foreignId('ward_id')->nullable()->constrained()->comment('id phường/xã');
            $table->string('representative_name')->comment('tên người đại diện');
            $table->string('representative_phone')->nullable()->comment('số điện thoại người đại diện');
            $table->string('representative_email')->nullable()->comment('email người đại diện');
            $table->foreignId('status_id')->constrained('system_statuses')->comment('trạng thái khách');
            $table->string('bank_number')->nullable()->comment('số tài khoản ngân hàng');
            $table->string('bank_username')->nullable()->comment('tên tài khoản ngân hàng');
            $table->foreignId('bank_id')->nullable()->constrained()->comment('id ngân hàng');
            $table->string('note')->nullable()->comment('ghi chú khách hàng');
            $table->tinyInteger('customer_type')->default(0)->comment('phân loại khách hàng: 0 - Thường, 1 - Vip');
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
        Schema::dropIfExists('customers');
    }
};
