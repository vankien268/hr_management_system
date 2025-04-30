<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Bank;
use Faker\Factory as Faker;
use App\Models\SystemStatus;
use App\Enums\StatusTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        $statuses = SystemStatus::where('type', StatusTypeEnum::CUSTOMER)->pluck('id')->toArray();
        $banks = Bank::pluck('id')->toArray();
        for ($i=0; $i < 50; $i++) {
            $arr = array();
            for ($j=0; $j < 10; $j++) {
                array_push($arr, [
                    'code' => $fake->ean8(),
                    'name' => $fake->name(),
                    'tax_code' => $fake->isbn10(),
                    'address' => $fake->streetAddress(),
                    'city_id' => 1,
                    'district_id' => rand(1, 30),
                    'ward_id' => null,
                    'representative_name' => $fake->name(),
                    'representative_phone' => $fake->e164PhoneNumber(),
                    'representative_email' => $fake->freeEmail(),
                    'status_id' => $statuses[array_rand($statuses)],
                    'bank_username' => strtoupper($fake->name()),
                    'bank_number' => $fake->bankAccountNumber(),
                    'bank_id' => $banks[array_rand($banks)],
                    'note' => $fake->text($maxNbChars = 100),
                    'customer_type' => rand(0, 1),
                    'user_id' => rand(1,5),
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]);
            }
            DB::table('customers')->insert($arr);
        }

    }
}
