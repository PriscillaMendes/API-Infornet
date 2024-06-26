<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Providers;
use Illuminate\Http\Request;
use App\Http\Utils\HgcDistance;
use App\Http\Controllers\Controller;
use App\Services\ExternalServicesUtils\ProvidersService;
use Illuminate\Validation\Rule;


class ProvidersController extends Controller
{
    protected $providersService;

    public function __construct(ProvidersService $providersService)
    {
        $this->providersService = $providersService;
    }

    public function index()
    {
        return response()->json([Providers::all()]);
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


    public function findProviders(Request $request)
    {   
        try{
             
            $validated = $request->validate([
                'origem.cidade' => 'required|string',
                'origem.uf' => 'required|string|max:2',
                'origem.latitude' => 'required|numeric',
                'origem.longitude' => 'required|numeric',
                'destino.cidade' => 'required|string',
                'destino.uf' => 'required|string|max:2',
                'destino.latitude' => 'required|numeric',
                'destino.longitude' => 'required|numeric',
                'servico_id' => 'required|integer',
                'quantidade' => 'nullable|integer|max:100',
                'ordenacao' => 'nullable|array|max:3',
                'ordenacao.*' => [
                    'nullable',
                    Rule::in(['total', 'distance', 'providers_status']),
                ],
                'filtros' => 'nullable|array|max:3',
                'filtros.*' => [
                    'nullable',
                    Rule::in(['cidade', 'estado', 'online', 'offline']),
                ],
            ]);

            if (empty($validated['ordenacao'])) {
                $orderList = ['total', 'distance', 'providers_status'];
            }
            else {
                $orderList = $validated['ordenacao'];
            }

            $latFrom = $validated['origem']['latitude'];
            $lonFrom = $validated['origem']['longitude'];
            $latTo = $validated['destino']['latitude'];
            $lonTo = $validated['destino']['longitude'];

            $hgcDistance = new HgcDistance();
            $serviceDistance = $hgcDistance->hGCDistance($latFrom, $lonFrom, $latTo, $lonTo);

            $distanceQuery = "( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?) )
            + sin( radians(?) ) *
            sin( radians( latitude ) ) ) ) + (?)";

            $query = "prestador.id, servico_prestador.servico_id, nome, logradouro, bairro, numero, cidade, UF, 
                ( 6371 * acos( cos( radians(?) ) *
                cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(?) )
                + sin( radians(?) ) *
                sin( radians( latitude ) ) ) ) + (?) AS distance, 
                CASE
                    WHEN ". $distanceQuery." > km_saida THEN ROUND(valor_saida+((". $distanceQuery . " - km_saida )*valor_km_excedente), 2)
                    ELSE ROUND(valor_saida, 2)
                END AS total";
                
            $providers = Providers::selectRaw($query)
                ->join('servico_prestador', 'prestador.id', '=', 'servico_prestador.prestador_id');
            
            $providers =$providers->where("servico_prestador.servico_id",  "servico_id");
            $whereQuery = [$validated['servico_id']];
            $statusFilter = False;
            if(!empty($validated['filtros'])){
                //TODO: Tratamento de filtros repetidos
                foreach($validated['filtros'] as $filter){
                    if ($filter == "cidade"){
                        $whereQuery[] = $validated['origem']['cidade'];
                        $providers =$providers->where("cidade",  "cidade");
                        
                    }elseif ($filter == "estado"){
                        $whereQuery[] = $validated['origem']['uf'];
                        $providers =$providers->where("UF",   "UF");
                    }elseif ($filter == "online" || $filter == "offline"){
                        $statusFilter = True;
                    }
                }
            }
            
            $orderByStatus = False;
            foreach ($orderList as $orderBy) {
                if (in_array($orderBy, ['distance', 'total'])) {
                   $providers->orderByRaw($orderBy);
                }elseif(in_array($orderBy, ['providers_status'])){
                    $orderByStatus = True;

                }
            }

            $val = array_merge([$latFrom, $lonFrom, $latFrom, $serviceDistance], [$latFrom, $lonFrom, $latFrom, $serviceDistance], [$latFrom, $lonFrom, $latFrom, $serviceDistance], $whereQuery);

            $providers =$providers->setBindings($val)
                            ->get();

            $arrProvider = [];
            foreach ($providers as $provider) {
                $arrProvider[] = $provider->id;
            }
            
            $status = $this->providersService->getProvidersStatus($arrProvider);
            
            $res = [];
            if($statusFilter){
                if(in_array("online", $validated['filtros'])){
                    for( $i = 0; $i < count($providers); $i++ ){
                        if($status["prestadores"][$i]['status'] == "Online"){
                            $providers[$i]->status = "Online";
                            $res[] = $providers[$i] ;
                        }
                    }
                }elseif(in_array("offline", $validated['filtros'])){
                    for( $i = 0; $i < count($providers); $i++ ){
                        if($status["prestadores"][$i]['status'] == "Offline"){
                            $providers[$i]->status = "Offline";
                            $res[] = $providers[$i];
                        }
                    }
                }
            }
            else{
                $res = $providers;
            }
            
            $auxResOff = [];
            $auxResOn = [];
            if(!$statusFilter && $orderByStatus){
                for( $i = 0; $i < count($res); $i++ ){
                    if($status["prestadores"][$i]['status']  == "Offline"){
                        $res[$i]->status = "Offline";;
                        $auxResOff[] =  $res[$i];
                    }
                    if($status["prestadores"][$i]['status']  == "Online"){
                        $res[$i]->status = "Online";;
                        $auxResOn[] =  $res[$i];
                    }

                }
                $res = array_merge($auxResOff, $auxResOn);
            }
            return response()->json([$res]);
            
        }catch (Exception $e){
            return response()->json(['error'=> $e->getMessage()],500);
        }
    }


    public function show(string $id)
    {
        return Providers::where('id', $id)->first();
    }

    public function show_all_by_addr(string $endereco)
    {
        return Providers::select('name', 'email')->where('id', $endereco)->first();
    }

}
