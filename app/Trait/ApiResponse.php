<?php

namespace App\trait;

trait ApiResponse
{
    public function success(string $message,array $data , int $code = 200){
        return response()->json([
            'success' => true,
            'message'=> $message,
            'data' => $data,
            'errors'=>[],
            'code' => $code
        ],$code);
    }
    public function error(string $message, int $code ,array $errors = []){
        return response()->json([
            'success' => false,
            'message'=> $message,
            'data' => [],
            'errors'=>$errors,
            'code' => $code
        ],$code);
    }

}
