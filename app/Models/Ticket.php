<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'description', 'status',
        'user_id', 'assigned_to', 'category_id', 'priority_id', 'room_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee()
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
}
