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
        Schema::create('department_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->comment('id bộ phận');
            $table->foreignId('user_id')->constrained()->comment('id bộ phận');
            $table->boolean('status')->default(1)->comment('trạng thái 1 - sử dụng, 0- ngưng sd');
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
        Schema::dropIfExists('department_users');
    }
};
