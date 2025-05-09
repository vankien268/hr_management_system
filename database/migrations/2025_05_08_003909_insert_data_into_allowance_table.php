<?php

use App\Models\Allowance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $allowanceTypes = [
            [
                'allowance_name' => 'Ăn trưa',
                'allowance_type' => Allowance::WORKED_DAYS_TYPE,
                'allowance_amount' => 500000,
                'description' => 'Loại phụ cấp ăn trưa',
                'valid' => 1,
                'allowed_number_days' => null,
                'default' => 1,
            ],
            [
                'allowance_name' => 'Xăng xe',
                'allowance_type' => Allowance::WORKED_DAYS_TYPE,
                'allowance_amount' => 200000,
                'description' => 'Loại phụ cấp xăng xe',
                'valid' => 1,
                'allowed_number_days' => null,
                'default' => 2,
            ],
            [
                'allowance_name' => 'Nuôi con nhỏ',
                'allowance_type' => Allowance::MANUAL_TYPE,
                'allowance_amount' => 300000,
                'description' => 'Loại phụ cấp nuôi con nhỏ',
                'valid' => 1,
                'allowed_number_days' => null,
                'default' => 3,
            ],
            [
                'allowance_name' => 'Chuyên cần',
                'allowance_type' => Allowance::WORKED_DAYS_TYPE,
                'allowance_amount' => 0,
                'description' => 'Loại phụ cấp ăn chuyên cần',
                'valid' => 1,
                'allowed_number_days' => null,
                'default' => 4,
            ]
        ];

        DB::table('allowances')->insert($allowanceTypes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
