<?php

namespace App\Repositories;

use App\Models\CarPark;
use App\Models\ParkingSlot;
use Illuminate\Database\Eloquent\Model;

interface CarParkRepositoryInterface
{
    /**
     * @param ParkingSlot $parkingSlot
     * @param array $data
     * @return Model
     */
    public function checkin(ParkingSlot $parkingSlot, array $data): Model;

    /**
     * @param ParkingSlot $parkingSlot
     * @param CarPark $carPark
     * @param array $data
     * @return bool
     */
    public function checkout(ParkingSlot $parkingSlot, CarPark $carPark, array $data): bool;
}
