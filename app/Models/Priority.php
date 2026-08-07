<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name', 'level', 'color'];
=======
    protected $fillable = [
        'name',
        'level',
        'color',
    ];
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
