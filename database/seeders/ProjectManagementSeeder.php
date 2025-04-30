<?php

namespace Database\Seeders;

use App\Enums\StatusTypeEnum;
use App\Models\City;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectFunctionUser;
use App\Models\ProjectType;
use App\Models\SystemStatus;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $getALlCountCity = City::pluck('id')->toArray() ?? [1];
        $projectTypes = ProjectType::pluck('id')->toArray() ?? [1];
        $customers = Customer::pluck('id')->toArray() ?? [1];
        $systemStatus = SystemStatus::get();
        $systemStatusActive =  $systemStatus->where('type', StatusTypeEnum::PROJECT)->where('status', 1)->pluck('id')->toArray();
        $taskTypeStatus =  $systemStatus->where('type', StatusTypeEnum::DIARY_PROJECT)->pluck('id')->toArray() ?? [1];
        $users = User::pluck('id')->toArray();
        $arrayNameContact = [
            'Nguyễn Văn Lộc',
            'Vũ Đức Nguyên',
            'Lê Văn Kiên',
            'Nguyễn Văn Nghiệp',
            'Phạm Hương',
            'Tuấn Cute',
            'Minh Nguyễn',
            'Phạm Văn Đồng',
            'Bùi Huy Hoàng',
            'Trần Đức Viễn',
            'Sơn Tùng MTP',
            'Phan Duy Mạnh',
        ];
        for ($i = 1; $i <= 100; $i++) {
                $randUserId = $users[array_rand($users)];
                $customerID = $customers[array_rand($customers)];
                $project = Project::create([
                    'code' => 'PR0' . $i,
                    'name' => 'Quản lý dự án 0' . $i,
                    'city_id' => $getALlCountCity[array_rand($getALlCountCity)],
                    'project_type_id' => $projectTypes[array_rand($projectTypes)],
                    'customer_id' => $customerID,
                    'status_id' =>$systemStatusActive[array_rand($systemStatusActive)],
                    'description' => 'Mô tả quản lý dự án 0' . $i,
                    'created_by' => $randUserId,
                    'updated_by' => $randUserId
                ]);
                $contact = Contact::create([
                    'name' => $arrayNameContact[array_rand($arrayNameContact)] . ' ' . $i,
                    'email' => 'Email6789' . $i . '@gmail.com',
                    'phone' => '0123456789',
                    'position' => 'Quản lý',
                    'customer_id' => $customerID
                ]);
                Task::create([
                    'date' =>  Carbon::now()->subMonth(rand(1, 8))->format('Y-m-d'),
                    'user_id' => $randUserId,
                    'project_id' => $project->id,
                    'status_id' =>  $taskTypeStatus[array_rand($taskTypeStatus)],
                    'description' => 'Miêu tả nhật ký dự án'
                ]);
                $permissionProject = [
                    [
                        'system_function_id' => 25,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 26,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 27,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 28,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 30,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 31,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 32,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 33,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 34,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 96,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 97,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 98,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 99,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                    [
                        'system_function_id' => 105,
                        'user_id' =>  $randUserId,
                        'project_id' => $project->id
                    ],
                ];
                ProjectFunctionUser::insert($permissionProject);
                $project->users()->attach($randUserId + 1, ['note' => 'Hãy liên hệ khách hàng vào T7, CN hàng tuần']);
                ProjectFunctionUser::create([
                    'user_id' => $randUserId + 1,
                    'system_function_id' => 25,
                    'project_id' => $project->id
                ]);
                $contact->projects()->attach($project->id, ['note' => 'Khách hàng ghi chú', 'status' => 1, 'position' => 1]);
        }
    }
}
