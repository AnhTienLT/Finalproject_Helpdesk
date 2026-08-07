<?php

namespace Database\Seeders;

<<<<<<< HEAD
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
=======
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $techRole = Role::where('name', 'Technician')->first();
        $userRole = Role::where('name', 'User')->first();

        $itDept = Department::where('name', 'IT')->first();
        $hrDept = Department::where('name', 'HR')->first();

        // Tạo tài khoản Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'role_id' => $adminRole->id,
            'department_id' => $itDept->id,
        ]);

        // Tạo tài khoản Kỹ thuật viên
        User::create([
            'name' => 'Nguyen Van Tech',
            'email' => 'tech@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0987654321',
            'role_id' => $techRole->id,
            'department_id' => $itDept->id,
        ]);

        // Tạo tài khoản Người dùng mẫu
        User::create([
            'name' => 'Tran Thi User',
            'email' => 'user@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0555666777',
            'role_id' => $userRole->id,
            'department_id' => $hrDept->id,
        ]);
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
    }
}
