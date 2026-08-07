<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'title' => 'Wifi phòng 101 bị mất kết nối',
                'description' => 'Từ sáng nay wifi phòng 101 không kết nối được, ảnh hưởng đến giảng dạy.',
                'status' => 'open', 'user_id' => 3, 'assigned_to' => null,
                'category_id' => 1, 'priority_id' => 3, 'room_id' => 1,
            ],
            [
                'title' => 'Cài đặt Office cho máy mới',
                'description' => 'Phòng Đào tạo cần cài Microsoft Office cho 5 máy tính mới.',
                'status' => 'in_progress', 'user_id' => 4, 'assigned_to' => 2,
                'category_id' => 2, 'priority_id' => 2, 'room_id' => 3,
            ],
            [
                'title' => 'Máy in phòng Kế toán bị kẹt giấy',
                'description' => 'Máy in HP LaserJet phòng Kế toán liên tục kẹt giấy.',
                'status' => 'resolved', 'user_id' => 5, 'assigned_to' => 2,
                'category_id' => 3, 'priority_id' => 2, 'room_id' => null,
            ],
            [
                'title' => 'Điều hòa phòng 301 không hoạt động',
                'description' => 'Điều hòa phòng làm việc CNTT bị hỏng, nhiệt độ phòng rất nóng.',
                'status' => 'open', 'user_id' => 2, 'assigned_to' => null,
                'category_id' => 5, 'priority_id' => 4, 'room_id' => 4,
            ],
            [
                'title' => 'Reset mật khẩu email cho nhân viên mới',
                'description' => 'Cần reset mật khẩu email cho 3 nhân viên mới phòng Hành chính.',
                'status' => 'closed', 'user_id' => 3, 'assigned_to' => 1,
                'category_id' => 4, 'priority_id' => 1, 'room_id' => null,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
