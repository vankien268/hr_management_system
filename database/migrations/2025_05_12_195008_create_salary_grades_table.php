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
            $table->float('coefficient_one')->nullable()->comment('hệ số 1');
            $table->float('value_one')->nullable();

            $table->float('coefficient_two')->nullable();
            $table->float('value_two')->nullable();

            $table->float('coefficient_three')->nullable();
            $table->float('value_three')->nullable();

            $table->float('coefficient_four')->nullable();
            $table->float('value_four')->nullable();

            $table->float('coefficient_five')->nullable();
            $table->float('value_five')->nullable();

            $table->float('coefficient_six')->nullable();
            $table->float('value_six')->nullable();

            $table->float('coefficient_seven')->nullable();
            $table->float('value_seven')->nullable();

            $table->float('coefficient_eight')->nullable();
            $table->float('value_eight')->nullable();

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
