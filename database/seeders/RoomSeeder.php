<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['name' => 'Phòng 101', 'location' => 'Tầng 1 - Tòa A', 'description' => 'Phòng máy tính 1'],
            ['name' => 'Phòng 102', 'location' => 'Tầng 1 - Tòa A', 'description' => 'Phòng máy tính 2'],
            ['name' => 'Phòng 201', 'location' => 'Tầng 2 - Tòa A', 'description' => 'Phòng họp lớn'],
            ['name' => 'Phòng 301', 'location' => 'Tầng 3 - Tòa B', 'description' => 'Phòng làm việc CNTT'],
            ['name' => 'Phòng 302', 'location' => 'Tầng 3 - Tòa B', 'description' => 'Phòng server'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
