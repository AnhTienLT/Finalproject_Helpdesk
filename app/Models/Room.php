<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name', 'location', 'description'];
=======
    protected $fillable = [
        'name',
        'location',
        'description',
    ];
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
