<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParkingSlot extends Model
{
    use HasFactory;

    const STATUS_AVAILABLE = 1;
    const STATUS_NOT_AVAILABLE = 0;

    protected $fillable = ['parking_id', 'car_park_id', 'status'];

    /**
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function carPark(): HasOne
    {
        return $this->hasOne(CarPark::class, 'id', 'car_park_id');
    }
}
