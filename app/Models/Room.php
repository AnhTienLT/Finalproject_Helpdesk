<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
