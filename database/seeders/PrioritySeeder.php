<?php

namespace Database\Seeders;

<<<<<<< HEAD
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
=======
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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        }
    }
}
