<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Thấp', 'level' => 1, 'color' => '#28a745'],
            ['name' => 'Trung bình', 'level' => 2, 'color' => '#ffc107'],
            ['name' => 'Cao', 'level' => 3, 'color' => '#fd7e14'],
            ['name' => 'Khẩn cấp', 'level' => 4, 'color' => '#dc3545'],
        ];

        foreach ($priorities as $pri) {
            Priority::create($pri);
        }
    }
}
