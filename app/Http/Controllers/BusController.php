<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function updateLocation(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $bus = Bus::updateOrCreate(
            ['bus_number' => $request->bus_number],
            ['latitude' => $request->latitude, 'longitude' => $request->longitude]
        );

        return response()->json(['status' => 'success', 'bus' => $bus]);
    }

    public function getLocation($bus_number)
    {
        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json(['error' => 'Bus not found'], 404);
        }

        return response()->json([
            'bus_number' => $bus->bus_number,
            'latitude' => $bus->latitude,
            'longitude' => $bus->longitude,
        ]);
    }
}
