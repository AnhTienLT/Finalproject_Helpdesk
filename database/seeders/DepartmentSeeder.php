<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'IT', 'description' => 'Phòng Công nghệ thông tin'],
            ['name' => 'HR', 'description' => 'Phòng Nhân sự'],
            ['name' => 'Accounting', 'description' => 'Phòng Kế toán'],
            ['name' => 'Sales', 'description' => 'Phòng Kinh doanh'],
            ['name' => 'Marketing', 'description' => 'Phòng Marketing'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
