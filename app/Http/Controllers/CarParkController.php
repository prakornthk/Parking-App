<?php

namespace App\Http\Controllers;

use App\Models\CarPark;
use App\Models\Parking;
use App\Models\ParkingSlot;
use App\Repositories\CarParkRepositoryInterface;
use App\Services\ParkingFeeCalculatorService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarParkController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly CarParkRepositoryInterface $carParkRepository
    )
    {
    }

    public function checkIn(Request $request, Parking $parking)
    {
        $availableSlot = $this->getAvailableParkingSlot($parking);

        if (!$availableSlot->exists()) {
            return $this->errorResponse('ขณะนี้ที่จอดเต็ม');
        }

        $data = [
            'license_plate' => $request->input('license_plate'),
            'check_in' => now(),
        ];

        $carPark = $this->carParkRepository->checkin(
            $availableSlot,
            $data
        );

        return $this->successResponse($carPark->toArray());
    }

    public function checkOut(ParkingSlot $parkingSlot)
    {
        $carPark = $parkingSlot->carPark;
        $checkoutTime = now();

        $parkingFee = ParkingFeeCalculatorService::calculate(
            $parkingSlot->parking->parking_fee,
            Carbon::create($carPark->check_in),
            $checkoutTime,
        );

        $data = [
            'check_out' => $checkoutTime,
            'parking_fee' => $parkingFee,
        ];

        $this->carParkRepository->checkout(
            $parkingSlot,
            $carPark,
            $data
        );

        return $this->successResponse($carPark->toArray());
    }

    /**
     * @param Parking $parking
     * @return ParkingSlot
     */
    private function getAvailableParkingSlot(Parking $parking): ParkingSlot
    {
        return $parking->parkingSlots()->whereStatus(ParkingSlot::STATUS_AVAILABLE)->first();
    }
}
