<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin HelpDesk', 'email' => 'admin@helpdesk.vn',
                'password' => bcrypt('password'), 'phone' => '0901000001',
                'role_id' => 1, 'department_id' => 1,
            ],
            [
                'name' => 'Nguyen Van Ky Thuat', 'email' => 'kythuat@helpdesk.vn',
                'password' => bcrypt('password'), 'phone' => '0901000002',
                'role_id' => 2, 'department_id' => 1,
            ],
            [
                'name' => 'Tran Thi Hanh Chinh', 'email' => 'hanhchinh@helpdesk.vn',
                'password' => bcrypt('password'), 'phone' => '0901000003',
                'role_id' => 3, 'department_id' => 2,
            ],
            [
                'name' => 'Le Van Dao Tao', 'email' => 'daotao@helpdesk.vn',
                'password' => bcrypt('password'), 'phone' => '0901000004',
                'role_id' => 3, 'department_id' => 3,
            ],
            [
                'name' => 'Pham Thi Ke Toan', 'email' => 'ketoan@helpdesk.vn',
                'password' => bcrypt('password'), 'phone' => '0901000005',
                'role_id' => 3, 'department_id' => 4,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
