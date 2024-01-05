<?php

namespace App\Services;

use Carbon\Carbon;

class ParkingFeeCalculatorService
{
    const FREE_PARKING_TIME = 15;

    /**
     * @param float $parkingRate
     * @param Carbon $checkIn
     * @param Carbon $checkOut
     * @return float
     */
    public static function calculate(float $parkingRate, Carbon $checkIn, Carbon $checkOut): float
    {
        $parkingDuration = $checkIn->diffInMinutes($checkOut);

        if ($parkingDuration <= self::FREE_PARKING_TIME) {
            return 0.0;
        } else {
            // If more than free parking time, round up to the nearest hour and calculate the parking fee
            $roundedDuration = ceil(($parkingDuration - self::FREE_PARKING_TIME) / 60);
            $fee = $parkingRate * $roundedDuration;

            return round($fee, 2);
        }
    }
}
