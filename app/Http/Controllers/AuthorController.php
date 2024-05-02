<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function index() {
        try {
            return Author::paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("AuthorController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function store(AuthorRequest $request)
    {
        try {
            $author = Author::create($request->all());

            return response()->json($author, 201);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("AuthorController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function update(Author $author, AuthorRequest $request)
    {
        try {
            $author->fill($request->all());
            $author->save();

            return response()->json('', 204);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("AuthorController.update: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function destroy(int $authorId) {
        try {
            Author::destroy($authorId);

            return response()->json('', 204);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("AuthorController.destroy: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
