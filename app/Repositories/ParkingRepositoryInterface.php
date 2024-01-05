<?php

namespace App\Repositories;

use App\Models\Parking;
use Illuminate\Database\Eloquent\Collection;

interface ParkingRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllParkings(): Collection;

    /**
     * @param $id
     * @return Parking
     */
    public function getParkingById($id): Parking;

    /**
     * @return Collection
     */
    public function getAllParkingsWithParkingSlots(): Collection;

    /**
     * @param array $data
     * @return Parking
     */
    public function createParking(array $data): Parking;

    /**
     * @param $id
     * @param array $data
     * @return Parking
     */
    public function updateParking($id, array $data): Parking;

    /**
     * @param $id
     * @return bool|null
     */
    public function deleteParking($id): ?bool;
}
