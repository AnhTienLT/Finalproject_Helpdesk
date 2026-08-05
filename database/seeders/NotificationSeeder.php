<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            ['user_id' => 2, 'title' => 'Ticket mới được gán cho bạn', 'message' => 'Ticket #2 "Cài đặt Office cho máy mới" đã được gán cho bạn xử lý.', 'is_read' => true],
            ['user_id' => 3, 'title' => 'Ticket đã được xử lý', 'message' => 'Ticket #5 "Reset mật khẩu email" đã được đóng. Vui lòng kiểm tra.', 'is_read' => false],
            ['user_id' => 1, 'title' => 'Cảnh báo tài sản hỏng', 'message' => 'Access Point UniFi U6 Pro (NW-002) tại Phòng 101 đã chuyển trạng thái sang "broken".', 'is_read' => false],
        ];

        foreach ($notifications as $noti) {
            Notification::create($noti);
        }
    }
}
