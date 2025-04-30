<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_groups')->insert(
            [
                [
                    'code' => 'ROOT',
                    'name' => 'DANH MỤC GỐC',
                    'tax_id' => null,
                    'fee_id' => null,
                    '_lft' => '1',
                    '_rgt' => '30',
                    'parent_id' => null,

                ],
                [
                    'code' => 'HH',
                    'name' => 'HÀNG HÓA',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '2',
                    '_rgt' => '27',
                    'parent_id' => 1,

                ],
                [
                    'code' => 'NVL',
                    'name' => 'NGUYÊN VẬT LIỆU',
                    'tax_id' => 3,
                    'fee_id' => 5,
                    '_lft' => '28',
                    '_rgt' => '29',
                    'parent_id' => 1,

                ],
                [
                    'code' => 'DA',
                    'name' => 'ĐỒ ĂN',
                    'tax_id' => 2,
                    'fee_id' => 5,
                    '_lft' => '11',
                    '_rgt' => '26',
                    'parent_id' => 2,

                ],
                [
                    'code' => 'DU',
                    'name' => 'ĐỒ UỐNG',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '3',
                    '_rgt' => '10',
                    'parent_id' => 2,

                ],
                [
                    'code' => 'BIA',
                    'name' => 'BIA',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '4',
                    '_rgt' => '9',
                    'parent_id' => 4,

                ],
                [
                    'code' => 'BIAKEN',
                    'name' => 'BIA HENIKEN',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '5',
                    '_rgt' => '6',
                    'parent_id' => 6,

                ],
                [
                    'code' => 'BIAHN',
                    'name' => 'BIA HÀ NỘI',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '7',
                    '_rgt' => '8',
                    'parent_id' => 6,

                ],
                [
                    'code' => 'BO',
                    'name' => 'MÓN BÒ',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '12',
                    '_rgt' => '13',
                    'parent_id' => 5,

                ],
                [
                    'code' => 'CA',
                    'name' => 'MÓN CÁ',
                    'tax_id' => 1,
                    'fee_id' => 5,
                    '_lft' => '14',
                    '_rgt' => '19',
                    'parent_id' => 5,

                ],
                [
                    'code' => 'THIT',
                    'name' => 'MÓN THỊT',
                    'tax_id' => 2,
                    'fee_id' => 5,
                    '_lft' => '20',
                    '_rgt' => '25',
                    'parent_id' => 5,

                ]
            ]
        );
    }
}
