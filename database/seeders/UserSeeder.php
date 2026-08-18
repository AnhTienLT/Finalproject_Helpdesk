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
        $userRole = Role::where('name', 'User')->first() ?? Role::where('name', 'Staff')->first();

        $itDept = Department::where('name', 'IT')->first() ?? Department::first();
        $hrDept = Department::where('name', 'HR')->first() ?? Department::first();

        // 1. System Admin (ID: 1)
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'role_id' => $adminRole->id,
            'department_id' => $itDept->id,
        ]);

        // 2. Technician (ID: 2)
        User::create([
            'name' => 'Nguyen Van Tech',
            'email' => 'tech@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0987654321',
            'role_id' => $techRole->id,
            'department_id' => $itDept->id,
        ]);

        // 3. User 1 (ID: 3)
        User::create([
            'name' => 'Tran Thi User',
            'email' => 'user@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0555666777',
            'role_id' => $userRole->id,
            'department_id' => $hrDept->id,
        ]);

        // 4. User 2 (ID: 4) - Cần cho TicketSeeder
        User::create([
            'name' => 'Le Van Dao Tao',
            'email' => 'daotao@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0444555666',
            'role_id' => $userRole->id,
            'department_id' => $hrDept->id,
        ]);

        // 5. User 3 (ID: 5) - Cần cho TicketSeeder
        User::create([
            'name' => 'Hoang Thi Ke Toan',
            'email' => 'ketoan@helpdesk.com',
            'password' => Hash::make('password'),
            'phone' => '0333444555',
            'role_id' => $userRole->id,
            'department_id' => $hrDept->id,
        ]);

        // Tạo thêm 10 nhân viên để kiểm tra tính năng phân trang
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Nhân viên mẫu $i",
                'email' => "user.test$i@helpdesk.com",
                'password' => Hash::make('password'),
                'phone' => '0900000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role_id' => $userRole->id,
                'department_id' => $hrDept->id,
            ]);
        }
    }
}
