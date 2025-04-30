<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('departments')->truncate();
        $departments = [
            [
                'name' => 'Ban giám đốc',
                'code' => 'BGD',
                'parent_id' => null,
                'note' => 'Ban giám đốc'
            ],
            [
                'name' => 'Ban phó giám đốc',
                'code' => 'BPGD',
                'parent_id' => null,
                'note' => 'Ban phó giám đốc'
            ],
            [
                'name' => 'Phòng công nghệ',
                'code' => 'PCN001',
                'parent_id' => null,
                'note' => null
            ],
            [
                'name' => 'Phòng công nghệ chi nhánh 1',
                'code' => 'BGD',
                'parent_id' => 3,
                'note' => 'Phòng công nghệ chi nhánh Hà Nội'
            ],
            [
                'name' => 'Phòng công nghệ chi nhánh 2',
                'code' => 'PCN002',
                'parent_id' => 3,
                'note' => 'Phòng công nghệ chi nhánh Hồ Chí Minh'
            ],
        ];
        foreach ($departments as $record) {
            Department::create($record);
        }
    }
}
