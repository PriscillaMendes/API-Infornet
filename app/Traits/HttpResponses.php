<?php

namespace App\Traits;

trait HttpResponses{
    public function response(string $message, string|int $status, array $data = [])
    {
        return response()->json([
            'message' => $message, 
            'status' => $status, 
            'data' => $data
        ]);
    }

    public function error(string $message, string|int $status, array $errors, array $data = []){
        return response()->json([
            'message' => $message, 
            'status' => $status, 
            'errors' => $errors,
            'data' => $data
        ]);
    }
}