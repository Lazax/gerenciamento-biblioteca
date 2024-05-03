<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index() 
    {
        try {
            return User::paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("UserController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function store(UserRequest $request) 
    {        
        try {
            $requestUser = $request->all();
            $requestUser['role'] = 'client';

            //dd($requestUser);
    
            $user = User::create($requestUser);
    
            return response()->json($user, 201);
            
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("UserController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
