<?php

namespace Database\Seeders;

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
        ];

        foreach ($categories as $cat) {
            AssetCategory::create($cat);
        }
    }
}
