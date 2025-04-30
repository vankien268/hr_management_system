<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        $data = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-31',
                'status' => 1,
                'department_id' => 1,
                'password' => bcrypt('Newway@2023')
            ],
            [
                'name' => 'Hương Phạm ',
                'username' => 'huong18',
                'email' => 'huong18@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-01',
                'status' => 1,
                'department_id' => 1,
                'password' => bcrypt('Admin123?')
            ],
            [
                'name' => 'Minh',
                'username' => 'minh18',
                'email' => 'minh18@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-01',
                'status' => 1,
                'department_id' => 1,
                'password' => bcrypt('Admin123?')
            ],
            [
                'name' => 'Anh Nghiệp',
                'username' => 'nghiep18',
                'email' => 'nghiep18@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-31',
                'status' => 1,
                'department_id' => 2,
                'password' => bcrypt('Newway@2023')
            ],
            [
                'name' => 'Tuan',
                'username' => 'tuan18',
                'email' => 'tuan18@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-31',
                'status' => 1,
                'department_id' => 2,
                'password' => bcrypt('Admin123?')
            ],
            [
                'name' => 'Kien Le Van',
                'username' => 'kienlv18',
                'email' => 'kienlv18@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '2000-01-31',
                'status' => 1,
                'department_id' => 2,
                'password' => bcrypt('Admin123?')
            ],
        ];
        User::insert($data);
        // foreach($data as $key => $item) {
        //     $i = $key + 1;
        //     RoleUser::insert([
        //        [
        //         'user_id' =>  $i,
        //         'role_id' => rand(1,3)
        //        ],
        //        [
        //         'user_id' => $i,
        //         'role_id' => rand(4,6)
        //        ]
        //     ]);
        // }
        // for ($i = 1; $i <= 10; $i++) {
        //     foreach ($data as $item) {
        //         $item['name'] = $item['name'] . ' ' . $i;
        //         $item['username'] = $item['username'] . $i;
        //         $user = User::create($item);
        //         RoleUser::insert([
        //             [
        //              'user_id' =>   $user->id,
        //              'role_id' => rand(1,3)
        //             ],
        //             [
        //              'user_id' =>  $user->id,
        //              'role_id' => rand(4,6)
        //             ]
        //          ]);
        //     }
        // }
    }
}
