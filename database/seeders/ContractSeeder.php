<?php

namespace Database\Seeders;

use DateTime;
use App\Models\User;
use App\Models\Project;
use App\Models\Customer;
use Faker\Factory as Faker;
use App\Models\ContractType;
use App\Models\SystemStatus;
use App\Enums\StatusTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        $projects = Project::get()->toArray();
        $customers = Customer::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $types = ContractType::pluck('id')->toArray();
        $statuses = SystemStatus::where('type', StatusTypeEnum::CONTRACT)->pluck('id')->toArray();

        for ($i = 0; $i < 240; $i++) {
            try {
                $signing = date("Y-m-d H:i", strtotime("- " . rand(0, 30) . " days"));
                $start = date("Y-m-d H:i", strtotime($signing . " + " . rand(5, 10) . " days"));
                $handOver = date("Y-m-d H:i", strtotime($start . " + " . rand(0, 60) . " days"));
                $expiration = date("Y-m-d H:i", strtotime($handOver . " + " . rand(15, 20) . " days"));
                $project = $projects[array_rand($projects)];
                DB::table('contracts')->insert([
                    'code' => $fake->ean8(),
                    'signing_date' => $signing,
                    'project_id' => $project['id'],
                    'customer_id' => $project['customer_id'],
                    'user_contractor_id' => $users[array_rand($users)],
                    'user_charge_id' => $users[array_rand($users)],
                    'customer_contractor' => $fake->name(),
                    'contract_type_id' => $types[array_rand($types)],
                    'contract_value' => rand(100000, 900000),
                    'start_date' => $start,
                    'expiration_date' => $expiration,
                    'hand_over_date' => $handOver,
                    'number_payment' => rand(1, 5),
                    'warranty_time' => rand(3, 36),
                    'status_id' => $statuses[array_rand($statuses)],
                    'note' => '',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
