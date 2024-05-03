<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where([
            'email' => $request->email
        ])->first();

        return $this->generateToken([
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ]);        
    }

    private function generateToken($payload = []){
        $date = new Carbon();
        $currentDate = $date->getTimestamp();
        $expireDate = $date->addHours((int) env('JWT_TOKEN_DURATION'))->getTimestamp();
        
        $payload = array_merge($payload, [
            'tokenInfo' => [
                'iss' => 'GerenciamentoBiblioteca.Api',
                'iat' => $currentDate,
                'nbt' => $currentDate,
                'exp' => $expireDate
            ]
        ]);

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}