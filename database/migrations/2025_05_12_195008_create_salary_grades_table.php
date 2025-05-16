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
        Schema::create('salary_grades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên bậc/ngạch lương');
            $table->float('coefficient_one', null, null)->nullable()->comment('hệ số 1');
            $table->float('value_one', null, null)->nullable();

            $table->float('coefficient_two', null, null)->nullable();
            $table->float('value_two', null, null)->nullable();

            $table->float('coefficient_three', null, null)->nullable();
            $table->float('value_three', null, null)->nullable();

            $table->float('coefficient_four', null, null)->nullable();
            $table->float('value_four', null, null)->nullable();

            $table->float('coefficient_five', null, null)->nullable();
            $table->float('value_five', null, null)->nullable();

            $table->float('coefficient_six', null, null)->nullable();
            $table->float('value_six', null, null)->nullable();

            $table->float('coefficient_seven', null, null)->nullable();
            $table->float('value_seven', null, null)->nullable();

            $table->float('coefficient_eight', null, null)->nullable();
            $table->float('value_eight', null, null)->nullable();

            $table->tinyInteger('valid')->default(1);

            $table->text('attributes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_grades');
    }
};
