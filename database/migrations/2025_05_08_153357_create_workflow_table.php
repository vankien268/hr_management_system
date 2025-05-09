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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('workflow_code')->nullable();
            $table->string('workflow_name')->nullable();
//            $table->tinyInteger('active')->nullable();
            $table->text('settings')->nullable();
            $table->text('description')->nullable();
            $table->text('dept_ids')->nullable();
            $table->tinyInteger('valid')->default(1);
//            $table->string('approval_method')->nullable();
            $table->string('workflow_type')->nullable();
            $table->string('approver_type')->nullable();
            $table->string('approver_ids')->nullable();
            $table->text('department_names')->nullable();

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
        Schema::dropIfExists('workflow');
    }
};
