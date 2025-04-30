<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ProjectType::truncate();
        $data = [
            [
                'code' => 'PLDA001',
                'name' => 'Loại dự án phần mềm khách sạn',
                'note' => 'Phần mềm được dùng trong quản lý khách sạn 3 sao trở lên',
                'status' => 1
            ],
            [
                'code' => 'PLDA002',
                'name' => 'Loại dự án phần mềm Golf',
                'note' => 'Phụ vụ cho việc quản lý giám sát và điều hành mọi hoạt động của sân Golf hoặc chuỗi sân Golf',
                'status' => 1
            ],
            [
                'code' => 'PLDA003',
                'name' => 'Loại dự án phần mềm kiểm soát',
                'note' => "",
                'status' => 1
            ],
            [
                'code' => 'PLDA030',
                'name' => 'Loại dự án phần mềm bán vé',
                'note' => "",
                'status' => 1
            ],
        ];
        for($i = 1; $i<=5; $i++) {
            foreach($data as $item) {
                $item['code'] = $item['code'].$i;
                $item['name'] = $item['name'].$i;
                ProjectType::create($item);
            }
        }
    }
}
