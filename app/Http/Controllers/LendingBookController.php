<?php

namespace App\Http\Controllers;

use App\Http\Requests\LendingBookRequest;
use App\Mail\LendingBook as MailLendingBook;
use App\Models\LendingBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LendingBookController extends Controller
{
    public function index()
    {
        try {
            return LendingBook::with([
                'user',
                'book.authors'
            ])->paginate(5);
        } catch(\Illuminate\Database\QueryException $e){
            Log::error("LendingBookController.index: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }

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
            return $e->getMessage();
            Log::error("LendingBookController.store: {$e->getMessage()}");
            
            return response()->json('Não foi possivel concluir a ação.', 500);
        }
    }
}
