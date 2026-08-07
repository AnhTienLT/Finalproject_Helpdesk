<?php

namespace Database\Seeders;

<<<<<<< HEAD
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
=======
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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
