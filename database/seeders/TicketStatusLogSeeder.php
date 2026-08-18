<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketStatusLog;
use Illuminate\Database\Seeder;

class TicketStatusLogSeeder extends Seeder
{
    /**
     * Backfill lịch sử trạng thái tối thiểu cho các ticket đã seed.
     * Mỗi ticket đều có ít nhất một dòng "open" (khi tạo);
     * ticket đang ở in_progress/resolved/closed sẽ có thêm log tương ứng.
     */
    public function run(): void
    {
        foreach (Ticket::all() as $ticket) {
            $author = $ticket->user_id;
            $assignee = $ticket->assigned_to ?? $author;

            TicketStatusLog::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => $author,
                'from_status' => null,
                'to_status'   => 'open',
                'note'        => 'Ticket được tạo (backfill).',
            ]);

            if (in_array($ticket->status, ['in_progress', 'resolved', 'closed'], true)) {
                TicketStatusLog::create([
                    'ticket_id'   => $ticket->id,
                    'user_id'     => $assignee,
                    'from_status' => 'open',
                    'to_status'   => 'in_progress',
                    'note'        => 'Chuyển sang xử lý (backfill).',
                ]);
            }
            if (in_array($ticket->status, ['resolved', 'closed'], true)) {
                TicketStatusLog::create([
                    'ticket_id'   => $ticket->id,
                    'user_id'     => $assignee,
                    'from_status' => 'in_progress',
                    'to_status'   => 'resolved',
                    'note'        => 'Đã giải quyết (backfill).',
                ]);
                $ticket->update(['resolved_at' => $ticket->updated_at]);
            }
            if ($ticket->status === 'closed') {
                TicketStatusLog::create([
                    'ticket_id'   => $ticket->id,
                    'user_id'     => $assignee,
                    'from_status' => 'resolved',
                    'to_status'   => 'closed',
                    'note'        => 'Đã đóng (backfill).',
                ]);
                $ticket->update(['closed_at' => $ticket->updated_at]);
            }
        }
    }
}
