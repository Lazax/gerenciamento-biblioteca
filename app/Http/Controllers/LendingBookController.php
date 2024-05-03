<?php

namespace App\Http\Controllers;

use App\Http\Requests\LendingBookRequest;
use App\Mail\LendingBook as MailLendingBook;
use App\Models\LendingBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LendingBookController extends Controller
{
    /**
     * @api {get} /user?lending_book=:page Listagem dos emprestimos
     * @apiPermission Admin
     * @apiPermission Client
     * @apiVersion 0.1.0
     * @apiName IndexLendingBook
     * @apiGroup LendingBook
     * @apiDescription Listagem dos emprestimos com paginação. Se o endpoint for utilizado pelo cliente será listado apenas os emprestimos vinculados a ele.
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
            switch (Auth::guard('api')->role()) {
                case 'admin':
                    return LendingBook::with([
                        'user',
                        'book.authors'
                    ])->paginate(5);
                    break;
                
                case 'client':
                    return LendingBook::whereUserId(Auth::guard('api')->id())->with([
                        'user',
                        'book.authors'
                    ])
                    ->paginate(5);
                    break;
            }            
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("LendingBookController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

    /**
     * @api {post} /lending_book Criar novo emprestimo
     * @apiPermission Admin
     * @apiVersion 0.1.0
     * @apiName StoreLendingBook
     * @apiGroup LendingBook
     * @apiDescription Cria um novo emprestimo.
     *
     * @apiParam (JSON) {Number} [user_id] ID do usuario que esta realizando o emprestimo
     * @apiParam (JSON) {Number} book_id ID do livro
     * @apiParam (JSON) {Date} return_date Data de entrega do livro
     * 
     * @apiParamExample {json} Request-Example:
     * {
     *  "user_id": "1",
     *  "book_id": "1",
     *  "return_date": "2024-10-10"
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
    public function store(LendingBookRequest $request)
    {        
        try {
            $lendingBook = LendingBook::create($request->all());
            $lendingBook->refresh();

            $lendingBook->load([
                'user',
                'book.authors'
            ]);

            $mail = new MailLendingBook($lendingBook);

            Mail::to('lordlazax@gmail.com')->queue($mail);

            return response()->json($lendingBook, 201);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("LendingBookController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
