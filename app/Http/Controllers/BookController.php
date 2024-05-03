<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * @api {get} /book?page=:page Listagem dos livros livro
     * @apiPermission Admin
     * @apiPermission Client
     * @apiVersion 0.1.0
     * @apiName IndexBook
     * @apiGroup Book
     * @apiDescription Listagem dos livros com paginação.
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
    public function index() {
        try {
            return Book::with('authors')->paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("BookController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    /**
     * @api {post} /book Criar novo livro
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName StoreBook
     * @apiGroup Book
     * @apiDescription Cria um novo livro.
     *
     * @apiParam (JSON) {String{255}} title Nome do livro
     * @apiParam (JSON) {String{4}} year Ano de publicação do livro
     * @apiParam (JSON) {Number[]} authors Array com os IDs dos autores do livro
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "title": "Lorem Ipsum",
     *  "year": "1900",
     *  "authors": [1, 2]
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

    /**
     * @api {post} /book/:id Editar livro
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName UpdateBook
     * @apiGroup Book
     * @apiDescription Editar um novo livro já existente.
     *
     * @apiParam {Number} id ID do autor
     * @apiParam (JSON) {String{255}} title Nome do livro
     * @apiParam (JSON) {String{4}} year Ano de publicação do livro
     * @apiParam (JSON) {Number[]} authors Array com os IDs dos autores do livro
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "title": "Lorem Ipsum",
     *  "year": "1900",
     *  "authors": [1, 2]
     * }
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 204 No Content
     *
     * @apiErrorExample Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *  "message": "Validation errors",
     *  "data": {}
     * }
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 500 Internal Server Error
     * {
     *  "Não foi possivel concluir a ação."
     * }
     */
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
    
    /**
     * @api {post} /book/:id Deletar livro
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName DestroyBook
     * @apiGroup Book
     * @apiDescription Deletar um novo livro já existente. Os emprestimos relacionados ao livro tambem serão deletados.
     *
     * @apiParam {Number} id ID do livro
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "title": "Lorem Ipsum",
     *  "year": "1900",
     *  "authors": [1, 2]
     * }
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 204 No Content
     *
     * @apiErrorExample Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *  "message": "Validation errors",
     *  "data": {}
     * }
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 500 Internal Server Error
     * {
     *  "Não foi possivel concluir a ação."
     * }
     */
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
