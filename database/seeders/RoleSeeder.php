<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Quản trị viên hệ thống'],
            ['name' => 'Technician', 'description' => 'Kỹ thuật viên xử lý yêu cầu'],
            ['name' => 'User', 'description' => 'Người dùng (Nhân viên)'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
