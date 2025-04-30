<?php

namespace Database\Seeders;

use App\Enums\DeploymentScheduleEnum;
use App\Models\DeploymentSchedule;
use App\Models\DeploymentScheduleDetail;
use App\Models\Project;
use App\Models\ProjectImplementer;
use App\Models\SystemStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DeploymentScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectsCount = Project::get()->count();
        $userCount = User::get()->count();
        $statusSystem = SystemStatus::where('type', 7)->get()->pluck('id')->toArray();
        $countStatusSystem = count($statusSystem);
        $deploySchedule = [
            'code' => 'DSCH0',
            'title' => 'Quản lý lịch triển khai dự án ',
            'project_id' => rand(1,  $projectsCount),
            'from_date' => now()->subDays(rand(6,28)),
            'to_date' => now(),
            'note' => 'Ghi chú lịch triển khai ',
            'status_id' => $countStatusSystem ? $statusSystem[rand(0,  $countStatusSystem - 1)] : 1,
            'contract_type_id' => 2
        ];
        for($i = 1; $i <= 60; $i++) {
            $deployScheduleCopy  = [...$deploySchedule];
            $deployScheduleCopy['code'] = $deployScheduleCopy['code']. $i;
            $deployScheduleCopy['title'] = $deployScheduleCopy['title']. $i;
            $deployScheduleCopy['note'] = $deployScheduleCopy['note']. $i;
            $depoymentScheduleStore = DeploymentSchedule::create($deployScheduleCopy);
            $day = now()->subDays(rand(2,8));
            $details = [
                [
                    'deployment_schedule_id' =>  $depoymentScheduleStore->id,
                    'day' => $day,
                    'shift' => 0,
                    'product_function' => 'Chức năng sản phẩm 1',
                    'description' => 'Diễn giải 1'
                ],
                [
                    'deployment_schedule_id' =>  $depoymentScheduleStore->id,
                    'day' => $day,
                    'shift' => 1,
                    'product_function' => 'Chức năng sản phẩm 2',
                    'description' => 'Diễn giải 2'
                ],
                [
                    'deployment_schedule_id' =>  $depoymentScheduleStore->id,
                    'day' => $day,
                    'shift' => 2,
                    'product_function' => 'Chức năng sản phẩm 3',
                    'description' => 'Diễn giải 3'
                ]
            ];
            #thêm chi tiết
            DeploymentScheduleDetail::insert($details);
            #Người thực hiện
            $projectImpementer = [
                'user_id' => rand(1,$userCount),
                'deployment_schedule_id' =>  $depoymentScheduleStore->id,
            ];
            ProjectImplementer::create($projectImpementer);
        }
    }
}
