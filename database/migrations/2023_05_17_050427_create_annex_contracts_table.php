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
        Schema::create('annex_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->comment('id hợp đồng');
            $table->date('date')->comment('ngày kí');
            $table->string('description')->comment('diễn giải');
            $table->string('code')->comment('số của phụ lục');
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
        Schema::dropIfExists('annex_contracts');
    }
};
