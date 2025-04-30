<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\SystemFunction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                "name" => "Quản trị hệ thống",
            ],
            [
                "name" => "Nhân viên",
            ],
            [
                "name" => "Kinh doanh",
            ],
            [
                "name" => "Quản lý",
            ],
            [
                "name" => "Nhóm quyền 5",
            ],
            [
                "name" => "Nhóm quyền 6",
            ],
            // [
            //     "name" => "Nhóm quyền 7",
            // ],
            // [
            //     "name" => "Nhóm quyền 8",
            // ],
            // [
            //     "name" => "Nhóm quyền 9",
            // ],
            // [
            //     "name" => "Nhóm quyền 10",
            // ],
            // [
            //     "name" => "Nhóm quyền 11",
            // ],
            // [
            //     "name" => "Nhóm quyền 12",
            // ],
            // [
            //     "name" => "Nhóm quyền 13",
            // ],
            // [
            //     "name" => "Nhóm quyền 14",
            // ],
            // [
            //     "name" => "Nhóm quyền 15",
            // ],
            // [
            //     "name" => "Nhóm quyền 16",
            // ],
            // [
            //     "name" => "Nhóm quyền 17",
            // ],
            // [
            //     "name" => "Nhóm quyền 18",
            // ],
            // [
            //     "name" => "Nhóm quyền 19",
            // ],
            // [
            //     "name" => "Nhóm quyền 20",
            // ],
            // [
            //     "name" => "Nhóm quyền 21",
            // ],
            // [
            //     "name" => "Nhóm quyền 22",
            // ],
            // [
            //     "name" => "Nhóm quyền 23",
            // ],
            // [
            //     "name" => "Nhóm quyền 24",
            // ],
            // [
            //     "name" => "Nhóm quyền 25",
            // ],
            // [
            //     "name" => "Nhóm quyền 26",
            // ],
            // [
            //     "name" => "Nhóm quyền 27",
            // ],
            // [
            //     "name" => "Nhóm quyền 28",
            // ],
            // [
            //     "name" => "Nhóm quyền 29",
            // ],
            // [
            //     "name" => "Nhóm quyền 30",
            // ],
            // [
            //     "name" => "Nhóm quyền 31",
            // ],
            // [
            //     "name" => "Nhóm quyền 32",
            // ],
            // [
            //     "name" => "Nhóm quyền 33",
            // ],
            // [
            //     "name" => "Nhóm quyền 34",
            // ],
            // [
            //     "name" => "Nhóm quyền 35",
            // ],
            // [
            //     "name" => "Nhóm quyền 36",
            // ],
            // [
            //     "name" => "Nhóm quyền 37",
            // ],
            // [
            //     "name" => "Nhóm quyền 38",
            // ],
            // [
            //     "name" => "Nhóm quyền 39",
            // ],
            // [
            //     "name" => "Nhóm quyền 40",
            // ],
            // [
            //     "name" => "Nhóm quyền 41",
            // ],
            // [
            //     "name" => "Nhóm quyền 42",
            // ],
            // [
            //     "name" => "Nhóm quyền 43",
            // ],
            // [
            //     "name" => "Nhóm quyền 44",
            // ],
            // [
            //     "name" => "Nhóm quyền 45",
            // ],
            // [
            //     "name" => "Nhóm quyền 46",
            // ],
            // [
            //     "name" => "Nhóm quyền 47",
            // ],
            // [
            //     "name" => "Nhóm quyền 48",
            // ],
            // [
            //     "name" => "Nhóm quyền 49",
            // ],
            // [
            //     "name" => "Nhóm quyền 50",
            // ],
            // [
            //     "name" => "Nhóm quyền 51",
            // ],
            // [
            //     "name" => "Nhóm quyền 51",
            // ],
            // [
            //     "name" => "Nhóm quyền 53",
            // ],
            // [
            //     "name" => "Nhóm quyền 54",
            // ],
            // [
            //     "name" => "Nhóm quyền 55",
            // ],
            // [
            //     "name" => "Nhóm quyền 56",
            // ],
            // [
            //     "name" => "Nhóm quyền 57",
            // ],
            // [
            //     "name" => "Nhóm quyền 58",
            // ],
            // [
            //     "name" => "Nhóm quyền 59",
            // ],
            // [
            //     "name" => "Nhóm quyền 60",
            // ],
            // [
            //     "name" => "Nhóm quyền 61",
            // ],
            // [
            //     "name" => "Nhóm quyền 62",
            // ],
            // [
            //     "name" => "Nhóm quyền 63",
            // ],
            // [
            //     "name" => "Nhóm quyền 64",
            // ],
            // [
            //     "name" => "Nhóm quyền 6",
            // ],
            // [
            //     "name" => "Nhóm quyền 65",
            // ],
            // [
            //     "name" => "Nhóm quyền 66",
            // ],
            // [
            //     "name" => "Nhóm quyền 67",
            // ],
            // [
            //     "name" => "Nhóm quyền 6",
            // ],
            // [
            //     "name" => "Nhóm quyền 68",
            // ],
            // [
            //     "name" => "Nhóm quyền 69",
            // ],
            // [
            //     "name" => "Nhóm quyền 70",
            // ],
            // [
            //     "name" => "Nhóm quyền 71",
            // ],
            // [
            //     "name" => "Nhóm quyền 72",
            // ],
            // [
            //     "name" => "Nhóm quyền 73",
            // ],
            // [
            //     "name" => "Nhóm quyền 74",
            // ],
            // [
            //     "name" => "Nhóm quyền 75",
            // ],
            // [
            //     "name" => "Nhóm quyền 76",
            // ],
            // [
            //     "name" => "Nhóm quyền 77",
            // ],
        ]);

        $users = User::where('id', '<', 25)->get();
        $funcs = SystemFunction::all();

        foreach ($funcs as $func) {
            if($func->code == 'SYSTEM_ADMIN'){
                DB::table('role_system_functions')->insert([
                    [
                        'system_function_id' => $func->id,
                        'role_id' => 1,
                    ]
                ]);
                continue;
            }
            DB::table('role_system_functions')->insert([
                // [
                //     'system_function_id' => $func->id,
                //     'role_id' => 1,
                // ],
                [
                    'system_function_id' => $func->id,
                    'role_id' => 2,
                ],
                [
                    'system_function_id' => $func->id,
                    'role_id' => 3,
                ]
            ]);
        }
        foreach ($users as $user){
            if($user->id < 7){
                DB::table('role_users')->insert([
                    // [
                    //     'user_id' => $user->id,
                    //     'role_id' => 1,
                    // ],
                    [
                        'user_id' => $user->id,
                        'role_id' => 1,
                    ]
                ]);
                continue;
            }
            DB::table('role_users')->insert([
                // [
                //     'user_id' => $user->id,
                //     'role_id' => 1,
                // ],
                [
                    'user_id' => $user->id,
                    'role_id' => 2,
                ],
                [
                    'user_id' => $user->id,
                    'role_id' => 3,
                ]
            ]);
        }

    }
}
