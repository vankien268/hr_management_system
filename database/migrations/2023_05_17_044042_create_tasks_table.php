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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('ngày ghi nhận');
            $table->foreignId('user_id')->nullable()->constrained()->comment('người thực hiện');
            $table->foreignId('project_id')->constrained()->comment('id dự án');
            $table->foreignId('status_id')->constrained('system_statuses')->comment('trạng thái');
            $table->string('description')->comment('diễn giải');
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
        Schema::dropIfExists('tasks');
    }
};
