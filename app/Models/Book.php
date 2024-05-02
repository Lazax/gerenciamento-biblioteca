<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['title', 'year'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
