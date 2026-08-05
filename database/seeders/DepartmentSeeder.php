<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Phòng CNTT', 'description' => 'Phòng Công nghệ thông tin'],
            ['name' => 'Phòng Hành chính', 'description' => 'Phòng Hành chính - Tổng hợp'],
            ['name' => 'Phòng Đào tạo', 'description' => 'Phòng Đào tạo'],
            ['name' => 'Phòng Kế toán', 'description' => 'Phòng Kế toán - Tài chính'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
