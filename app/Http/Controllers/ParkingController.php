<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Repositories\ParkingRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    use ResponseTrait;
    /**
     * @param ParkingRepositoryInterface $parkingRepository
     */
    public function __construct(
        private readonly ParkingRepositoryInterface $parkingRepository
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $parkings = $this->parkingRepository->getAllParkingsWithParkingSlots();
        return $this->successResponse($parkings->toArray());
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->parkingRepository->createParking([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'parking_fee' => $request->input('parking_fee'),
        ]);
    }

    /**
     * @param int $parking
     * @return void
     */
    public function destroy(int $parking)
    {
        $this->parkingRepository->deleteParking($parking);
    }
}
