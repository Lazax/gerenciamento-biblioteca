<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index() {
        try {
            return Book::with('authors')->paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("BookController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function store(BookRequest $request)
    {
        try {
            DB::beginTransaction();

            $book = new Book();
            $book->title = $request->title;
            $book->year = $request->year;
            $book->save();
            $book->authors()->attach($request->authors);

            DB::commit();

            $book->load('authors');

            return response()->json($book, 201);
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollBack();
            
            Log::error("BookController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function update(Book $book, BookRequest $request)
    {        
        try {
            $book->fill($request->all());
            $book->save();
            $book->authors()->sync($request->authors);
    
            return response()->json('', 204);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("BookController.update: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    public function destroy(int $bookId) {
        try {
            Book::destroy($bookId);

            return response()->json('', 204);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("BookController.destroy: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
