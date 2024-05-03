<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    /**
     * @api {get} /author?page=:page Listagem dos autores
     * @apiPermission Admin
     * @apiPermission Client
     * @apiVersion 0.1.0
     * @apiName IndexAuthor
     * @apiGroup Author
     * @apiDescription Listagem dos autores com paginação.
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
            return Author::paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("AuthorController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    /**
     * @api {post} /author Criar novo autor
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName StoreAuthor
     * @apiGroup Author
     * @apiDescription Cria um novo autor.
     *
     * @apiParam (JSON) {String{255}} name Nome do autor
     * @apiParam (JSON) {Date} date_of_birth Data de aniversario do autor
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "email": "Lorem Ipsum",
     *  "date_of_birth": "1900-01-01"
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

    /**
     * @api {put} /author/:id Editar autor
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName UpdateAuthor
     * @apiGroup Author
     * @apiDescription Editar um autor já existente.
     *
     * @apiParam {Number} id ID do autor
     * @apiParam (JSON) {String{255}} name Nome do autor
     * @apiParam (JSON) {Date} date_of_birth Data de aniversario do autor
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "email": "Lorem Ipsum",
     *  "date_of_birth": "1900-01-01"
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

    /**
     * @api {delete} /author/:id Deletar autor
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName DestroyAuthor
     * @apiGroup Author
     * @apiDescription Deletar um autor já existente. Os livros do autor e os emprestimos relacionados ao autor tambem serão deletados.
     *
     * @apiParam {Number} id ID do autor
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 204 No Content
     * 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 500 Internal Server Error
     * {
     *  "Não foi possivel concluir a ação."
     * }
     */
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
