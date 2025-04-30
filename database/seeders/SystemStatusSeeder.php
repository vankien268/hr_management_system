<?php

namespace Database\Seeders;

use App\Enums\StatusTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SystemStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_statuses')->insert(
            [
                //'Trạng thái dự án' => StatusTypeEnum::PROJECT,
                [
                    'name' => 'Khởi tạo',
                    'note' => 'Giai đoạn Khởi tạo (Initiating)',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                [
                    'name' => 'Lên kế hoạch',
                    'note' => 'Giai đoạn Lên kế hoạch (Planning)',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                [
                    'name' => 'Thực thi',
                    'note' => 'Giai đoạn Thực thi (Executing)',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                [
                    'name' => 'Giám sát và Kiểm soát',
                    'note' => 'Giai đoạn Giám sát và Kiểm soát (Monitoring & Controlling)',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                [
                    'name' => 'Đóng dự án',
                    'note' => 'Giai đoạn Đóng dự án (Closing)',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                [
                    'name' => 'Tổng kết',
                    'note' => 'Giai đoạn Tổng kết',
                    'type' => StatusTypeEnum::PROJECT,
                ],
                //'Trạng thái hợp đồng' => StatusTypeEnum::CONTRACT,
                [
                    'name' => 'Báo giá hợp đồng',
                    'note' => 'Giai đoạn Báo giá',
                    'type' => StatusTypeEnum::CONTRACT,
                ],
                [
                    'name' => 'Kí kết hợp đồng',
                    'note' => 'Giai đoạn Kí kết hợp đồng',
                    'type' => StatusTypeEnum::CONTRACT,
                ],
                [
                    'name' => 'Bàn giao hợp đồng',
                    'note' => 'Giai đoạn Bàn giao hợp đồng',
                    'type' => StatusTypeEnum::CONTRACT,
                ],
                //'Trạng thái khách hàng' => StatusTypeEnum::CUSTOMER,
                [
                    'name' => 'Khách hàng tiền năng',
                    'note' => 'Giai đoạn 1',
                    'type' => StatusTypeEnum::CUSTOMER,
                ],
                [
                    'name' => 'Khách hàng ưu tiên cao',
                    'note' => 'Giai đoạn 2',
                    'type' => StatusTypeEnum::CUSTOMER,
                ],
                [
                    'name' => 'Khách hàng vip',
                    'note' => 'Giai đoạn 3',
                    'type' => StatusTypeEnum::CUSTOMER,
                ],
                //'Trạng thái nhật kí dự án' => StatusTypeEnum::DIARY_PROJECT,
                [
                    'name' => 'Xúc tiến dự án',
                    'note' => 'Giai đoạn',
                    'type' => StatusTypeEnum::DIARY_PROJECT,
                ],
                [
                    'name' => 'Báo giá hợp đồng',
                    'note' => 'Giai đoạn',
                    'type' => StatusTypeEnum::DIARY_PROJECT,
                ],
                [
                    'name' => 'Chăm sóc khách hàng',
                    'note' => 'Giai đoạn',
                    'type' => StatusTypeEnum::DIARY_PROJECT,
                ],
                //'Trạng thái  => StatusTypeEnum::DIARY_PROJECT,
                [
                    'name' => 'Xúc tiến dự án',
                    'note' => 'Giai đoạn',
                    'type' => 6,
                ],
                [
                    'name' => 'Báo giá hợp đồng',
                    'note' => 'Giai đoạn',
                    'type' => 6,
                ],
                [
                    'name' => 'Chăm sóc khách hàng',
                    'note' => 'Giai đoạn',
                    'type' => 6,
                ],
            ]
        );

        for( $i = 4; $i <= 7; $i++){
            DB::table('system_statuses')->insert([
                [
                    'name' => 'Chưa triển khai',
                    'note' => 'Không',
                    'type' => $i,
                ],
                [
                    'name' => 'Đã triển khai',
                    'note' => 'Không',
                    'type' => $i,
                ],
                [
                    'name' => 'Đã hủy',
                    'note' => 'Không',
                    'type' => $i,
                ],
            ]);
        }
    }
}
