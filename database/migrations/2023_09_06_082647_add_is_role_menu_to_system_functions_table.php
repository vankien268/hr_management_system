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
        Schema::table('system_functions', function (Blueprint $table) {
            $table->boolean('is_role_menu')->default(0)->comment('quyền menu');
            // $table->string('route_name')->nullable()->comment('quyền menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_functions', function (Blueprint $table) {
            //
        });
    }
};
