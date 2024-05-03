@component('mail::message')

# Olá {{ $lendingBook->user->name }}

Esse é um e-mail de confirmação do seu novo emprestimo.

Livro: {{ $lendingBook->book->title }}

Data do emprestimo: {{ $lendingBook->loan_date }}

Data de devolução: {{ $lendingBook->return_date }}
    
@endcomponent