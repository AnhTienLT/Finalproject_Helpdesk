<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Quản trị viên hệ thống'],
            ['name' => 'Technician', 'description' => 'Nhân viên kỹ thuật xử lý ticket'],
            ['name' => 'Staff', 'description' => 'Nhân viên tạo yêu cầu hỗ trợ'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
