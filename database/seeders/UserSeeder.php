<?php

namespace Database\Seeders;

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
    }
}
