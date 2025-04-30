<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                "code" => "VND",
                "name" => "Việt Nam Đồng",
            ],
            [
                "code" => "CAI",
                "name" => "Cái",
            ],
            [
                "code" => "CHIEC",
                "name" => "Chiếc",
            ],
        ]);
    }
}
