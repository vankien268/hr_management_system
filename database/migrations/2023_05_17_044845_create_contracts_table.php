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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('số hợp đồng');
            $table->date('signing_date')->comment('ngày kí');
            $table->integer('project_id')->comment('id dự án');
            $table->integer('user_contractor_id')->comment('id người kí bên công ty');
            $table->integer('user_charge_id')->comment('id phụ trách bên công ty');
            $table->string('customer_contractor')->comment('người kí bên khách hàng');
            $table->integer('customer_id')->comment('id khách hàng');
            $table->integer('contract_type_id')->comment('loại hợp đồng');
            $table->bigInteger('contract_value')->comment('giá trị hợp đồng');
            $table->date('start_date')->comment('ngày bắt đầu thực hiện');
            $table->date('expiration_date')->comment('ngày hết hạn hợp đồng');
            $table->date('hand_over_date')->comment('ngày nghiệm thu hợp đồng');
            $table->integer('number_payment')->comment('số lần thanh toán');
            $table->integer('warranty_time')->comment('thời gian bảo hành 3 - 36 tháng');
            $table->integer('status_id')->comment('trạng thái dự án');
            $table->string('note_contract')->nullable()->comment('lưu ý quan trọng');
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
        Schema::dropIfExists('contracts');
    }
};
