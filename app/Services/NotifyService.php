<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;

class NotifyService
{
    public function __construct(private Ticket $ticket) {}

    public static function for(Ticket $ticket): self
    {
        return new self($ticket);
    }

    /**
     * Danh sách người cần thông báo (chủ ticket + người được gán), loại actor.
     * @return int[]
     */
    private function recipients(?User $actor): array
    {
        $ids = [];
        if ($this->ticket->user_id) $ids[] = $this->ticket->user_id;
        if ($this->ticket->assigned_to) $ids[] = $this->ticket->assigned_to;
        $ids = array_unique($ids);
        if ($actor) {
            $ids = array_values(array_filter($ids, fn ($id) => $id !== $actor->id));
        }
        return $ids;
    }

    private function push(int $userId, string $title, string $message, string $type): void
    {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'link'    => route('tickets.show', $this->ticket->id),
            'type'    => $type,
            'is_read' => false,
        ]);
    }

    public function assigned(User $actor): void
    {
        $title = "Ticket #{$this->ticket->id} đã được tiếp nhận";
        $message = "{$actor->name} đã tiếp nhận yêu cầu \"{$this->ticket->title}\".";
        foreach ($this->recipients($actor) as $uid) {
            $this->push($uid, $title, $message, 'ticket_assigned');
        }
    }

    public function statusChanged(User $actor, string $from, string $to): void
    {
        $title = "Ticket #{$this->ticket->id}: {$from} → {$to}";
        $message = "{$actor->name} đã cập nhật trạng thái yêu cầu \"{$this->ticket->title}\".";
        foreach ($this->recipients($actor) as $uid) {
            $this->push($uid, $title, $message, 'status_changed');
        }
    }

    public function newResponse(User $actor): void
    {
        $title = "Ticket #{$this->ticket->id} có phản hồi mới";
        $message = "{$actor->name} vừa gửi phản hồi cho yêu cầu \"{$this->ticket->title}\".";
        foreach ($this->recipients($actor) as $uid) {
            $this->push($uid, $title, $message, 'response');
        }
    }
}
