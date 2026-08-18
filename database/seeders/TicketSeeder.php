<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Room;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách ID để gán động
        $users = User::pluck('id')->toArray();
        $techs = User::whereHas('role', function($q) {
            $q->where('name', 'Technician');
        })->pluck('id')->toArray();
        $admins = User::whereHas('role', function($q) {
            $q->where('name', 'Admin');
        })->pluck('id')->toArray();

        $categories = Category::pluck('id')->toArray();
        $priorities = Priority::pluck('id')->toArray();
        $rooms = Room::pluck('id')->toArray();

        $tickets = [
            [
                'title' => 'Wifi phòng 101 bị mất kết nối',
                'description' => 'Từ sáng nay wifi phòng 101 không kết nối được, ảnh hưởng đến giảng dạy.',
                'status' => 'open',
                'user_id' => $users[2] ?? 1,
                'assigned_to' => null,
                'category_id' => $categories[2] ?? 1,
                'priority_id' => $priorities[2] ?? 1,
                'room_id' => $rooms[0] ?? null,
            ],
            [
                'title' => 'Cài đặt Office cho máy mới',
                'description' => 'Phòng Đào tạo cần cài Microsoft Office cho 5 máy tính mới.',
                'status' => 'in_progress',
                'user_id' => $users[3] ?? 1,
                'assigned_to' => $techs[0] ?? null,
                'category_id' => $categories[0] ?? 1,
                'priority_id' => $priorities[1] ?? 1,
                'room_id' => $rooms[2] ?? null,
            ],
            [
                'title' => 'Máy in phòng Kế toán bị kẹt giấy',
                'description' => 'Máy in HP LaserJet phòng Kế toán liên tục kẹt giấy.',
                'status' => 'resolved',
                'user_id' => $users[4] ?? 1,
                'assigned_to' => $techs[0] ?? null,
                'category_id' => $categories[1] ?? 1,
                'priority_id' => $priorities[1] ?? 1,
                'room_id' => null,
            ],
            [
                'title' => 'Điều hòa phòng 301 không hoạt động',
                'description' => 'Điều hòa phòng làm việc CNTT bị hỏng, nhiệt độ phòng rất nóng.',
                'status' => 'open',
                'user_id' => $users[1] ?? 1,
                'assigned_to' => null,
                'category_id' => $categories[4] ?? 1,
                'priority_id' => $priorities[3] ?? 1,
                'room_id' => $rooms[3] ?? null,
            ],
            [
                'title' => 'Reset mật khẩu email cho nhân viên mới',
                'description' => 'Cần reset mật khẩu email cho 3 nhân viên mới phòng Hành chính.',
                'status' => 'closed',
                'user_id' => $users[2] ?? 1,
                'assigned_to' => $admins[0] ?? null,
                'category_id' => $categories[3] ?? 1,
                'priority_id' => $priorities[0] ?? 1,
                'room_id' => null,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
