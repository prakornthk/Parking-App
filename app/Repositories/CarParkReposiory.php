<?php

namespace App\Repositories;

use App\Models\CarPark;
use App\Models\ParkingSlot;
use Illuminate\Database\Eloquent\Model;

class CarParkReposiory implements CarParkRepositoryInterface
{
    /**
     * @param ParkingSlot $parkingSlot
     * @param array $data
     * @return Model
     */
    public function checkin(ParkingSlot $parkingSlot, array $data): Model
    {
        $carPark = $parkingSlot->carPark()->create($data);

        $parkingSlot->update([
            'car_park_id' => $carPark->id,
            'status' => 0,
        ]);

        return $carPark;
    }

    /**
     * @param ParkingSlot $parkingSlot
     * @param CarPark $carPark
     * @param array $data
     * @return bool
     */
    public function checkout(ParkingSlot $parkingSlot, CarPark $carPark, array $data): bool
    {
        $parkingSlot->update([
            'car_park_id' => null,
            'status' => 1,
        ]);
        return $carPark->update($data);
    }

}
