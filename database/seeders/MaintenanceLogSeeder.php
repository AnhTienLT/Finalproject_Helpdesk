<?php

namespace Database\Seeders;

use App\Models\MaintenanceLog;
use Illuminate\Database\Seeder;

class MaintenanceLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            ['asset_id' => 5, 'performed_by' => 2, 'description' => 'Kiểm tra Access Point. Phát hiện board mạch bị cháy, cần thay mới.', 'maintenance_date' => '2026-07-28', 'cost' => 0],
            ['asset_id' => 6, 'performed_by' => 2, 'description' => 'Thay bộ kéo giấy và drum. Máy in hoạt động trở lại bình thường.', 'maintenance_date' => '2026-08-01', 'cost' => 850000],
            ['asset_id' => 7, 'performed_by' => 2, 'description' => 'Kiểm tra điều hòa. Compressor bị hỏng, báo giá thay thế 3.500.000đ.', 'maintenance_date' => '2026-08-03', 'cost' => null],
        ];

        foreach ($logs as $log) {
            MaintenanceLog::create($log);
        }
    }
}
