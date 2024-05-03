<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @api {get} /user?page=:page Listagem dos usuarios
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName IndexUser
     * @apiGroup Usuario
     * @apiDescription Listagem dos usuarios com paginação.
     *
     * @apiParam {Number} page Numero da pagina
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 500 Internal Server Error
     * {
     *  "Não foi possivel concluir a ação."
     * }
     */
    public function index()
    {
        try {
            return User::paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("UserController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    /**
     * @api {post} /user Criar novo usuario
     * @apiVersion 0.1.0
     * @apiName StoreUser
     * @apiGroup Usuario
     * @apiDescription Cria um novo usuario.
     *
     * @apiParam (JSON) {String{255}} name Nome do usuario
     * @apiParam (JSON) {Email|String{255}} email E-mail do usuario
     * @apiParam (JSON) {String{255}} password Senha do usuario
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "name": "Lorem Ipsum",
     *  "email": "lorem@ipsum.com",
     *  "password": "123456"
     * }
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 201 Created
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
    public function store(UserRequest $request) 
    {        
        try {
            $requestUser = $request->all();
            $requestUser['role'] = 'client';
    
            $user = User::create($requestUser);
    
            return response()->json($user, 201);
            
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("UserController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
