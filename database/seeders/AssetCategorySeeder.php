<?php

namespace Database\Seeders;

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
        ];

        foreach ($categories as $cat) {
            AssetCategory::create($cat);
        }
    }
}
