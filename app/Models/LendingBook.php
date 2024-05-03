<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingBook extends Model
{
    protected $table = 'lending_books';
    
    protected $fillable = [
        'user_id',
        'book_id',
        'return_date'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
