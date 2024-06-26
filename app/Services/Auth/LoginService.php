<?php

namespace App\Services\Auth;

use Exception;

class LoginService{
    
    public function execute(array $credentials){
        
        if (!$token = auth()->setTTl(6*60)->attempt($credentials)) {
            throw new Exception("Not Authorized",401);
        }

        return [
            "access_token" => $token,
            "token_type"=> "bearer",
            "expires_in"=>  auth()->factory()->getTTL(),
            'user' => auth()->user()->name,
        ];
    }
}