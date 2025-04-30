<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TaxFeeRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            WardSeeder::class,
            BankSeeder::class,
            DepartmentSeeder::class,
            SystemStatusSeeder::class,
            ContractTypeSeeder::class,
            // CustomerSeeder::class,
            ProjectTypeSeeder::class,
            UserSeeder::class,
            // ProjectManagementSeeder::class,
            // ContractSeeder::class,
            // ProductSeeder::class,
            UnitSeeder::class,
            TaxFeeRateSeeder::class,
            ProductGroupSeeder::class,
            // QuoteSeeder::class,
            // DeploymentRecordSeeder::class,
            // DeploymentScheduleSeeder::class,
            // AcceptanceRecordSeeder::class,
            // DispatchSeeder::class,
            SystemFunctionSeeder::class,
            RoleSeeder::class,
            // PaymentDetailSeeder::class,
        ]);
        // $this->command->info('Seeding!!!!!!');

        // $path = 'database/seeders/project_mgr_15_07.sql';
        // DB::unprepared(file_get_contents($path));
        // $this->command->info('Seeded!!!!!!');
    }
}
