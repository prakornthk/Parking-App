<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function parkingSlot(Parking $parking)
    {
        return view('pages.parking-slot', compact('parking'));
    }
}
