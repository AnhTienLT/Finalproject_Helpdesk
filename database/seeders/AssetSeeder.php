<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID động từ các bảng liên quan
        $categories = AssetCategory::pluck('id')->toArray();
        $rooms = Room::pluck('id')->toArray();

        // Đảm bảo có ít nhất 1 giá trị để tránh lỗi nếu bảng trống
        $defaultCat = $categories[0] ?? 1;
        $defaultRoom = $rooms[0] ?? 1;

        $assets = [
            [
                'name' => 'PC Dell OptiPlex 7090 #01',
                'asset_code' => 'PC-001',
                'asset_category_id' => $categories[0] ?? $defaultCat,
                'room_id' => $rooms[0] ?? $defaultRoom,
                'status' => 'active',
                'purchase_date' => '2024-03-15',
                'description' => 'Core i5-11500, 16GB RAM, 512GB SSD'
            ],
            [
                'name' => 'PC Dell OptiPlex 7090 #02',
                'asset_code' => 'PC-002',
                'asset_category_id' => $categories[0] ?? $defaultCat,
                'room_id' => $rooms[0] ?? $defaultRoom,
                'status' => 'active',
                'purchase_date' => '2024-03-15',
                'description' => 'Core i5-11500, 16GB RAM, 512GB SSD'
            ],
            [
                'name' => 'Laptop HP ProBook 450 G8',
                'asset_code' => 'LT-001',
                'asset_category_id' => $categories[0] ?? $defaultCat,
                'room_id' => $rooms[3] ?? $defaultRoom,
                'status' => 'active',
                'purchase_date' => '2023-09-01',
                'description' => 'Core i7-1165G7, 16GB RAM'
            ],
            [
                'name' => 'Switch Cisco SG350-28',
                'asset_code' => 'NW-001',
                'asset_category_id' => $categories[1] ?? $defaultCat,
                'room_id' => $rooms[1] ?? $defaultRoom, // Thay đổi từ 5 sang 1 (Phòng Kỹ thuật) cho an toàn
                'status' => 'active',
                'purchase_date' => '2023-01-10',
                'description' => '28-port Gigabit Managed Switch'
            ],
            [
                'name' => 'Access Point UniFi U6 Pro',
                'asset_code' => 'NW-002',
                'asset_category_id' => $categories[1] ?? $defaultCat,
                'room_id' => $rooms[0] ?? $defaultRoom,
                'status' => 'broken',
                'purchase_date' => '2023-06-20',
                'description' => 'Wifi 6 Access Point - đang hỏng'
            ],
            [
                'name' => 'Máy in HP LaserJet Pro M404dn',
                'asset_code' => 'PR-001',
                'asset_category_id' => $categories[2] ?? $defaultCat,
                'room_id' => $rooms[2] ?? $defaultRoom,
                'status' => 'maintenance',
                'purchase_date' => '2022-11-05',
                'description' => 'Máy in laser đen trắng - đang bảo trì'
            ],
            [
                'name' => 'Điều hòa Daikin FTKM50SVM',
                'asset_code' => 'AC-001',
                'asset_category_id' => $categories[4] ?? $defaultCat,
                'room_id' => $rooms[3] ?? $defaultRoom,
                'status' => 'broken',
                'purchase_date' => '2021-07-15',
                'description' => '2HP Inverter - đang hỏng'
            ],
            [
                'name' => 'Projector Epson EB-X51',
                'asset_code' => 'PJ-001',
                'asset_category_id' => $categories[2] ?? $defaultCat,
                'room_id' => $rooms[2] ?? $defaultRoom,
                'status' => 'active',
                'purchase_date' => '2024-01-20',
                'description' => 'Máy chiếu 3800 lumens'
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
