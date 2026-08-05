<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Mạng & Internet', 'description' => 'Sự cố mạng, wifi, kết nối internet'],
            ['name' => 'Phần mềm', 'description' => 'Cài đặt, cập nhật, lỗi phần mềm'],
            ['name' => 'Phần cứng', 'description' => 'Hỏng máy tính, màn hình, bàn phím, chuột'],
            ['name' => 'Tài khoản & Quyền', 'description' => 'Reset mật khẩu, cấp quyền truy cập'],
            ['name' => 'Cơ sở vật chất', 'description' => 'Điều hòa, đèn, bàn ghế, phòng họp'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
