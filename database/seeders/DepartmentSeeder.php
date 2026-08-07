<?php

namespace Database\Seeders;

<<<<<<< HEAD
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
=======
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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
