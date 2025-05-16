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
        Schema::create('pay_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pay_roll_id')->nullable();
            $table->integer('level')->nullable();
            $table->float('position_based_pay', null, null)->nullable()->default(0)->comment('Lương theo vị trí');
            $table->float('person_based_pay', null, null)->nullable()->default(0)->comment('Lương theo năng lực');
            $table->float('performance_based_pay', null, null)->nullable()->default(0)->comment('Lương theo hiệu suất cv');

            $table->tinyInteger('valid')->default(1);
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
        Schema::dropIfExists('pay_ranges');
    }
};
