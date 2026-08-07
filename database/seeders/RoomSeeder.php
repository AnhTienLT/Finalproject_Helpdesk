<?php

namespace Database\Seeders;

<<<<<<< HEAD
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
=======
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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
