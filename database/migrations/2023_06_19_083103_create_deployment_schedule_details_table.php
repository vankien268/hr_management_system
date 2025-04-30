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
        Schema::create('deployment_schedule_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deployment_schedule_id')->constrained()->comment('dự án');
            $table->date('day')->nullable()->comment('ngày');
            $table->tinyInteger('shift')->comment('ca làm việc 0 là ca sáng, 1 ca chiều, 2 ca tối');
            $table->string('product_function')->nullable()->comment('chức năng sản phẩm');
            $table->string('description')->nullable()->comment('diễn giải');
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
        Schema::dropIfExists('deployment_schedule_details');
    }
};
