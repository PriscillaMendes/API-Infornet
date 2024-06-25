<?php

namespace App\Services\ExternalServicesUtils;

use Illuminate\Support\Facades\Http;


class GeocodeService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.geocode.url');
        $this->username = config('services.external_services_auth.username');
        $this->password = config('services.external_services_auth.password');
    }

    public function getCoordinates($address)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get($this->baseUrl . urlencode($address));

        if ($response->successful()) {
            $data = $response->json();
            return [
                'latitude' => $data['lat'],
                'longitude' => $data['lon'],
            ];
        }

        return null;
    }
}
