<?php

namespace App\Services\GeoUtils;

use Illuminate\Support\Facades\Http;

class GeocodeService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.geocode.url');
        $this->username = config('services.geocode.username');
        $this->password = config('services.geocode.password');
    }

    public function getCoordinates($address)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get($this->baseUrl . urlencode($address));

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
