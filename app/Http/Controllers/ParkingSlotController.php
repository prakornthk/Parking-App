<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\ParkingSlot;
use App\Repositories\ParkingSlotRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly ParkingSlotRepository $parkingSlotRepositoryRepository
    )
    {
    }

    /**
     * @param Parking $parking
     * @return JsonResponse
     */
    public function index(Parking $parking)
    {
        return $this->successResponse(
            $this->parkingSlotRepositoryRepository->getParkingSlots($parking)->toArray()
        );
    }

    /**
     * @param Parking $parking
     * @return JsonResponse
     */
    public function store(Parking $parking)
    {
        return $this->successResponse(
            $this->parkingSlotRepositoryRepository->addParkingSlot($parking)->toArray()
        );
    }

    public function destroy(int $parkingSlotId)
    {
        $this->parkingSlotRepositoryRepository->deleteParkingSlot($parkingSlotId);
        return $this->successResponse([]);
    }
}
