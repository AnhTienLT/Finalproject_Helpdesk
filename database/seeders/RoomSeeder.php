<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['name' => 'Phòng họp A1', 'location' => 'Tầng 1', 'description' => 'Phòng họp lớn'],
            ['name' => 'Phòng Kỹ thuật', 'location' => 'Tầng 2', 'description' => 'Khu vực làm việc IT'],
            ['name' => 'Phòng Giám đốc', 'location' => 'Tầng 3', 'description' => 'Văn phòng lãnh đạo'],
            ['name' => 'Sảnh chính', 'location' => 'Tầng G', 'description' => 'Khu vực tiếp khách'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
