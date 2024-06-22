<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\Auth\LoginService;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    use HttpResponses;
    private $loginService;
    public function __construct(LoginService $loginService){
        $this->loginService = $loginService;
    }
    public function login(Request $request){
        try{

            $credentials = $request->only('name', 'password');
            $auth = $this->loginService->execute($credentials);
            return $auth;
            

        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        
       
    }
    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

   public function me(){
        try{
            return response()->json(auth()->user(), 200);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}

