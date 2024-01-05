<?php

namespace App\Repositories;

use App\Models\Parking;
use App\Models\ParkingSlot;
use Illuminate\Database\Eloquent\Collection;

interface ParkingSlotRepositoryInterface
{
    /**
     * @param Parking $parking
     * @return Collection
     */
    public function getParkingSlots(Parking $parking): Collection;

    /**
     * @param Parking $parking
     * @return ParkingSlot
     */
    public function addParkingSlot(Parking $parking): ParkingSlot;

    /**
     * @param int $id
     * @return bool|null
     */
    public function deleteParkingSlot(int $id): ?bool;
}
