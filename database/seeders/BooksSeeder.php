<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alanMoore = Author::whereName('Alan Moore')->first();
        $cliveBarker = Author::whereName('Clive Barker')->first();
        $EdBrubaker = Author::whereName('Ed Brubaker')->first();
        $seanPhilips = Author::whereName('Sean Philips')->first();
        $philipKDick = Author::whereName('Philip K. Dick')->first();
        $stephenKing = Author::whereName('Stephen King')->first();

        $book = new Book();
        $book->title = 'Reckless';
        $book->year = 2022;
        $book->save();
        $book->authors()->attach([
            $EdBrubaker->id,
            $seanPhilips->id
        ]);

        $book = new Book();
        $book->title = 'Um fim de semana ruims';
        $book->year = 2019;
        $book->save();
        $book->authors()->attach([
            $EdBrubaker->id,
            $seanPhilips->id
        ]);

        $book = new Book();
        $book->title = 'Fatale';
        $book->year = 2014;
        $book->save();
        $book->authors()->attach([
            $EdBrubaker->id,
            $seanPhilips->id
        ]);

        $book = new Book();
        $book->title = 'Do Inferno';
        $book->year = 1989;
        $book->save();
        $book->authors()->attach([
            $alanMoore->id
        ]);

        $book = new Book();
        $book->title = 'Iluminações';
        $book->year = 2022;
        $book->save();
        $book->authors()->attach([
            $alanMoore->id
        ]);

        $book = new Book();
        $book->title = 'Livros de Sangue Vol. 1';
        $book->year = 1984;
        $book->save();
        $book->authors()->attach([
            $cliveBarker->id
        ]);

        $book = new Book();
        $book->title = 'O Ladrão da Eternidade';
        $book->year = 1992;
        $book->save();
        $book->authors()->attach([
            $cliveBarker->id
        ]);

        $book = new Book();
        $book->title = 'Androides Sonham com Ovelhas Elétricas?';
        $book->year = 1968;
        $book->save();
        $book->authors()->attach([
            $philipKDick->id
        ]);

        $book = new Book();
        $book->title = 'O Homem do Castelo Alto';
        $book->year = 1962;
        $book->save();
        $book->authors()->attach([
            $philipKDick->id
        ]);

        $book = new Book();
        $book->title = 'Carie';
        $book->year = 1974;
        $book->save();
        $book->authors()->attach([
            $stephenKing->id
        ]);

        $book = new Book();
        $book->title = 'O Iluminado';
        $book->year = 1977;
        $book->save();
        $book->authors()->attach([
            $stephenKing->id
        ]);        
    }
}
