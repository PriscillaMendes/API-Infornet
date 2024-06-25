<?php

namespace App\Services\ExternalServicesUtils;

use Illuminate\Support\Facades\Http;

class ProvidersService
{
    protected $prestadoresUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->prestadoresUrl = config('services.prestadores.url');
        $this->username = config('services.external_services_auth.username');
        $this->password = config('services.external_services_auth.password');
    }

    public function getProvidersStatus(array $providers)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withBody(json_encode(['prestadores' => $providers]), 'application/json')
            ->get($this->prestadoresUrl);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
