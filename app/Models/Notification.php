<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
<<<<<<< HEAD
    protected $fillable = ['user_id', 'title', 'message', 'is_read'];
=======
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
