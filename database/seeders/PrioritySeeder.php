<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1, 'color' => '#28a745'],
            ['name' => 'Medium', 'level' => 2, 'color' => '#ffc107'],
            ['name' => 'High', 'level' => 3, 'color' => '#fd7e14'],
            ['name' => 'Urgent', 'level' => 4, 'color' => '#dc3545'],
        ];

        foreach ($priorities as $p) {
            Priority::create($p);
        }
    }
}
