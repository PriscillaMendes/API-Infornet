<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Providers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExternalServicesUtils\ProvidersService;

class ProvidersController extends Controller
{
    protected $providersService;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([Providers::all()]);
    }


    public function __construct(ProvidersService $providersService)
    {
        $this->providersService = $providersService;
    }


    public function getProvidersStatus(Request $request)
    {   
        $providers = $request->get("prestadores");

        if (!$providers || !is_array($providers)) {
            return response()->json(['error' => 'Prestadores are required and should be an array'], 400);
        }


        $status = $this->providersService->getProvidersStatus($providers);

        if ($status) {
            return response()->json($status);
        }

        return response()->json(['error' => 'Unable to fetch prestadores status'], 500);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Providers::where('id', $id)->first();
    }

    public function show_all_by_addr(string $endereco)
    {
        return Providers::select('name', 'email')->where('id', $endereco)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
