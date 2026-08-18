<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'assigned_to',
        'category_id',
        'priority_id',
        'room_id',
        'resolution_note',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class)->orderBy('created_at');
    }
}
