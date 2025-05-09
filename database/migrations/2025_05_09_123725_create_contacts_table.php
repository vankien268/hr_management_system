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
            $table->string('contact_code')->nullable(); // Mã nhân viên
            $table->string('contact_first_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('contact_gender')->nullable(); // 1 = Nam, 2 = Nữ
            $table->date('contact_birthday')->nullable();

            $table->string('contact_email')->nullable();
            $table->string('contact_facebook')->nullable();
            $table->string('contact_zalo')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_mobile_2')->nullable();

            $table->string('contact_identify')->nullable()->comment("Số CMTND/CCCD");
            $table->unsignedBigInteger('contact_identify_day')->comment('Ngày cấp')->nullable();
            $table->string('contact_identify_place')->comment('
"Nơi cấp CMTND/CCCD"')->nullable();

            $table->string('contact_marital_status')->nullable();
//            $table->tinyInteger('contact_people_type')->nullable();
//            $table->tinyInteger('contact_religious_type')->nullable();
            $table->string('contact_national')->nullable();
            $table->unsignedBigInteger('contact_status_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('contact_tax_code')->nullable()->comment('Mã số thuế');
            $table->unsignedBigInteger('contact_tax_code_date')->nullable()->comment('Ngày mã số thuế'); // timestamp

            $table->string('atm_number')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->string('permanent_address')->nullable()->comment("Địa chỉ thường trú");
            $table->string('temporary_address')->nullable()->comment(
                "Địa chỉ tạm trú");
            $table->string('contact_home_town')->nullable()->comment("Nguyên quán");
            $table->string('relative_phone_number')->nullable()->comment("Số điện thoại người thân");

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
