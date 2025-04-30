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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('mã bộ phận');
            $table->string('name')->comment('tên bộ phận');
            $table->string('note')->nullable()->comment('ghi chú bộ phận');
            $table->tinyInteger('status')->default(1)->comment('1 là sử dụng, 0 là ngừng sd trạng thái bộ phận');
            \Kalnoy\Nestedset\NestedSet::columns($table);
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
        Schema::dropIfExists('departments');
    }
};
