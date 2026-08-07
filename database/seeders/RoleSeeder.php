<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
=======
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Quản trị viên hệ thống'],
<<<<<<< HEAD
            ['name' => 'Technician', 'description' => 'Nhân viên kỹ thuật xử lý ticket'],
            ['name' => 'Staff', 'description' => 'Nhân viên tạo yêu cầu hỗ trợ'],
=======
            ['name' => 'Technician', 'description' => 'Kỹ thuật viên xử lý yêu cầu'],
            ['name' => 'User', 'description' => 'Người dùng (Nhân viên)'],
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
