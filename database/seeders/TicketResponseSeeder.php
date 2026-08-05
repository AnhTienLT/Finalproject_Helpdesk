<?php

namespace Database\Seeders;

use App\Models\TicketResponse;
use Illuminate\Database\Seeder;

class TicketResponseSeeder extends Seeder
{
    public function run(): void
    {
        $responses = [
            ['ticket_id' => 2, 'user_id' => 2, 'message' => 'Đã nhận ticket. Sẽ qua cài đặt Office trong chiều nay.'],
            ['ticket_id' => 2, 'user_id' => 4, 'message' => 'Cảm ơn anh, phòng sẽ chuẩn bị sẵn máy.'],
            ['ticket_id' => 3, 'user_id' => 2, 'message' => 'Đã kiểm tra và thay bộ kéo giấy. Máy in hoạt động bình thường.'],
            ['ticket_id' => 5, 'user_id' => 1, 'message' => 'Đã reset mật khẩu cho 3 tài khoản. Mật khẩu mới đã gửi qua email cá nhân.'],
        ];

        foreach ($responses as $resp) {
            TicketResponse::create($resp);
        }
    }
}
