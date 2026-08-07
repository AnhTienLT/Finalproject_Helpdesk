<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Thứ tự quan trọng: bảng cha trước, bảng con sau (ràng buộc FK).
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            CategorySeeder::class,
            PrioritySeeder::class,
            RoomSeeder::class,
            AssetCategorySeeder::class,
            UserSeeder::class,
<<<<<<< HEAD
            NotificationSeeder::class,
            TicketSeeder::class,
            TicketResponseSeeder::class,
            AssetSeeder::class,
            MaintenanceLogSeeder::class,
=======
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
        ]);
    }
}
