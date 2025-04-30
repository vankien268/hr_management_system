<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxFeeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tax_fee_rates')->insert([
            [
                'code' => 'V8',
                'description' => 'Thuế GTGT 8%',
                'rate' => 8,
                'type' => 0,
                'note' => 'Thuế phí',
            ],
            [
                'code' => 'V10',
                'description' => 'Thuế GTGT 10%',
                'rate' => 10,
                'type' => 0,
                'note' => 'Thuế phí',
            ], [
                'code' => 'V7',
                'description' => 'Thuế GTGT 7%',
                'rate' => 7,
                'type' => 0,
                'note' => 'Thuế phí',
            ], [
                'code' => 'T30',
                'description' => 'Thuế TTĐB 30%',
                'rate' => 30,
                'type' => 0,
                'note' => 'Thuế phí',
            ], [
                'code' => 'P5',
                'description' => 'Phí Dịch vụ 5%',
                'rate' => 5,
                'type' => 1,
                'note' => 'Thuế phí',
            ], [
                'code' => 'P10',
                'description' => 'Phí dịch vụ 10%',
                'rate' => 10,
                'type' => 1,
                'note' => 'Thuế phí',
            ],
        ]);
    }
}
