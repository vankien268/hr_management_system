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

            $table->string('contract_name')->nullable();
            $table->string('contract_code')->nullable();
            $table->string('contract_number')->nullable();
            $table->unsignedBigInteger('contact_type_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable()->comment('Phòng ban người lao động');
            $table->unsignedBigInteger('contact_id')->nullable()->comment('Id nhân sự');

            $table->unsignedBigInteger('signer_user_id')->nullable()->comment('Người đại diện phía công ty');
            $table->unsignedBigInteger('signer_department_id')->nullable();

            $table->dateTime('register_date')->nullable();
            $table->string('time_limited')->nullable()->comment('Thời hạn hợp đồng');
            $table->string('work_type')->nullable()->comment('Hình thức thử việc');
            $table->float('basic_salary')->nullable()->comment('Mức lương cơ bản');
            $table->dateTime('effective_date')->nullable()->comment('Ngày bắt đầu hiệu lực');
            $table->dateTime('expiration_date')->nullable()->comment('Ngày kết thúc hiệu lực');
            $table->string('allowances')->nullable();

            $table->text('note')->nullable();

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
        Schema::dropIfExists('hrm_contracts');
    }
};
