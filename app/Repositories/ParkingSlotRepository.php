<?php

namespace App\Repositories;

use App\Models\Parking;
use App\Models\ParkingSlot;
use Illuminate\Database\Eloquent\Collection;

class ParkingSlotRepository implements ParkingSlotRepositoryInterface
{

    public function getParkingSlots(Parking $parking): Collection
    {
        return $parking->parkingSlots()->with('carPark')->get();
    }

    public function addParkingSlot(Parking $parking): ParkingSlot
    {
        return $parking->parkingSlots()->create([
            'status' => 1,
        ]);
    }

    public function deleteParkingSlot(int $id): ?bool
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        return $parkingSlot->delete();
    }
}
