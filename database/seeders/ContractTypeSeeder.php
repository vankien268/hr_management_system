<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contract_types')->insert(
            [
                //'Trạng thái dự án' => StatusTypeEnum::PROJECT,
                [
                    'code' => 'LHD00001',
                    'name' => 'Hợp đồng cung cấp phần Mềm',
                    'note' => 'Giới thiệu phần Mềm',
                ],
                [
                    'code' => 'LHD00002',
                    'name' => 'Chuyển giao phần mềm',
                    'note' => '',
                ],
                [
                    'code' => 'LHD00003',
                    'name' => 'Ủy quyền phần Mềm',
                    'note' => '',
                ],
                [
                    'code' => 'LHD00004',
                    'name' => 'Hợp tác',
                    'note' => '',
                ],
                [
                    'code' => 'LHD00005',
                    'name' => 'Thuê phần Mềm',
                    'note' => '',
                ],
            ]
        );
    }
}
