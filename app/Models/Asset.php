<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
<<<<<<< HEAD
        'name', 'asset_code', 'asset_category_id', 'room_id',
        'status', 'purchase_date', 'description',
    ];

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class);
=======
        'name',
        'asset_code',
        'asset_category_id',
        'room_id',
        'status',
        'purchase_date',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
