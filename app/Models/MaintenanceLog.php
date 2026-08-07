<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
<<<<<<< HEAD
    protected $fillable = ['asset_id', 'performed_by', 'description', 'maintenance_date', 'cost'];
=======
    protected $fillable = [
        'asset_id',
        'performed_by',
        'description',
        'maintenance_date',
        'cost',
    ];
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
