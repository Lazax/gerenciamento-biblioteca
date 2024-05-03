<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * @api {post} /auth/login Realizar login
     * @apiVersion 0.1.0
     * @apiName LoginAuth
     * @apiGroup Auth
     * @apiDescription Realiza um novo login.
     *
     * @apiParam (JSON) {Email|String{255}} email E-mail do usuario
     * @apiParam (JSON) {String{255}} password Senha do usuario
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "email": "lorem@ipsum.com",
     *  "password": "123456"
     * }
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     *
     * @apiErrorExample Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *  "message": "Validation errors",
     *  "data": {}
     * }
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 500 Internal Server Error
     * {
     *  "Não foi possivel concluir a ação."
     * }
     */
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