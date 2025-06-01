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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('tên người dùng');
            $table->string('username')->comment('tên đăng nhập người dùng');
            $table->string('avatar')->nullable()->comment('ảnh đại diện người dùng');
            $table->string('password')->comment('mật khẩu');
            $table->string('email')->comment('email người dùng');
            $table->bigInteger('department_id')->comment('Id bảng bộ phận');
            $table->string('phone')->nullable()->comment('số điện thoại người dùng');
            $table->tinyInteger('gender')->default(0)->comment('giới tính: 0 - Nam/Nữ, 1 : Nam, 2: Nữ');
            $table->date('birthday')->nullable()->comment('số điện thoại người dùng');
            $table->string('status')->default(1)->comment('1 là active, 0 là block');
//            $table->integer('login_number')->nullable()->default(0)->comment('số lần login');
//            $table->string('skype')->nullable()->comment('Link skype người dùng nếu có');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
