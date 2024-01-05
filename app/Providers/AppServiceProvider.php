<?php

namespace App\Providers;

use App\Repositories\CarParkReposiory;
use App\Repositories\CarParkRepositoryInterface;
use App\Repositories\ParkingRepository;
use App\Repositories\ParkingRepositoryInterface;
use App\Repositories\ParkingSlotRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ParkingRepositoryInterface::class, ParkingRepository::class);
        $this->app->bind(ParkingSlotRepository::class, ParkingSlotRepository::class);
        $this->app->bind(CarParkRepositoryInterface::class, CarParkReposiory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
