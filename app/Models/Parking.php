<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'parking_fee'];

    /**
     * @return HasMany
     */
    public function parkingSlots(): HasMany
    {
        return $this->hasMany(ParkingSlot::class, 'parking_id', 'id');
    }
}
