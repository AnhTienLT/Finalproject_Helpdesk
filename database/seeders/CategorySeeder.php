<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Software', 'description' => 'Lỗi phần mềm, ứng dụng'],
            ['name' => 'Hardware', 'description' => 'Lỗi phần cứng, máy tính, thiết bị'],
            ['name' => 'Network', 'description' => 'Lỗi mạng, Internet, Wifi'],
            ['name' => 'Account/Access', 'description' => 'Lỗi tài khoản, mật khẩu, quyền truy cập'],
            ['name' => 'Other', 'description' => 'Các vấn đề khác'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
