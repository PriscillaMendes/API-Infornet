<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExternalServicesUtils\GeocodeService;

class GeocodeController extends Controller
{
    protected $geocodeService;

    public function __construct(GeocodeService $geocodeService)
    {
        $this->geocodeService = $geocodeService;
    }

    public function getCoordinates(string $address)
    {
        if (!$address) {
            return response()->json(['error' => 'Address is required'], 400);
        }

        $coordinates = $this->geocodeService->getCoordinates($address);

        if ($coordinates) {
            return response()->json($coordinates);
        }

        return response()->json(['error' => 'Unable to fetch coordinates'], 500);
    }
}
