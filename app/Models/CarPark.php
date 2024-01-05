<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarPark extends Model
{
    use HasFactory;

    protected $fillable = ['parking_slot_id', 'license_plate', 'check_in', 'check_out', 'parking_fee', 'status'];

    /**
     * @return BelongsTo
     */
    public function parkingSlot(): BelongsTo
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id', 'id');
    }
}
