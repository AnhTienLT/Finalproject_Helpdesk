<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Máy tính', 'description' => 'PC, Laptop, All-in-one'],
            ['name' => 'Thiết bị mạng', 'description' => 'Router, Switch, Access Point'],
            ['name' => 'Thiết bị ngoại vi', 'description' => 'Máy in, Scanner, Projector'],
            ['name' => 'Nội thất', 'description' => 'Bàn, ghế, tủ'],
            ['name' => 'Điện lạnh', 'description' => 'Điều hòa, quạt'],
=======
use Illuminate\Database\Seeder;
use App\Models\AssetCategory;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop/PC', 'description' => 'Máy tính xách tay và máy tính để bàn'],
            ['name' => 'Monitor', 'description' => 'Màn hình máy tính'],
            ['name' => 'Printer', 'description' => 'Máy in, máy scan'],
            ['name' => 'Network Device', 'description' => 'Router, Switch, Hub'],
            ['name' => 'Furniture', 'description' => 'Bàn, ghế, tủ văn phòng'],
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ];

        foreach ($categories as $cat) {
            AssetCategory::create($cat);
        }
    }
}
