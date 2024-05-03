<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Alan Moore',
            'date_of_birth' => '1953-11-18'
        ]);

        Author::create([
            'name' => 'Clive Barker',
            'date_of_birth' => '1952-10-05'
        ]);

        Author::create([
            'name' => 'Ed Brubaker',
            'date_of_birth' => '1966-11-17'
        ]);

        Author::create([
            'name' => 'Sean Philips',
            'date_of_birth' => '1966-11-17'
        ]);

        Author::create([
            'name' => 'Philip K. Dick',
            'date_of_birth' => '1982-12-16'
        ]);

        Author::create([
            'name' => 'Stephen King',
            'date_of_birth' => '1957-09-21'
        ]);
    }
}
