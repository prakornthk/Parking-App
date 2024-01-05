<?php

namespace App\Repositories;

use App\Models\Parking;
use Illuminate\Database\Eloquent\Collection;

class ParkingRepository implements ParkingRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllParkings(): Collection
    {
        return Parking::all();
    }

    /**
     * @param $id
     * @return Parking
     */
    public function getParkingById($id): Parking
    {
        return Parking::findOrFail($id);
    }

    public function getAllParkingsWithParkingSlots(): Collection
    {
        return Parking::with('parkingSlots')->get();
    }

    /**
     * @param array $data
     * @return Parking
     */
    public function createParking(array $data): Parking
    {
        return Parking::create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return Parking
     */
    public function updateParking($id, array $data): Parking
    {
        $parking = Parking::findOrFail($id);
        $parking->update($data);

        return $parking;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function deleteParking($id): ?bool
    {
        $parking = Parking::findOrFail($id);
        return $parking->delete();
    }
}
