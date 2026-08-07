<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
<<<<<<< HEAD
    protected $fillable = ['ticket_id', 'user_id', 'message'];
=======
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
