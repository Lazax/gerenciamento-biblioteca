<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Gerenciamento de Biblioteca

# Como rodar este projeto

## Instalação

Clonar repositorio

    git clone https://github.com/Lazax/gerenciamento-biblioteca.git

Mudar para o diretorio do projeto

    cd gerenciamento-biblioteca

Instalar dependencias usando o Composer

    composer install

Copiar arquivos .env

    cp .env.example .env

Realizar as configurações do banco de dados (preferencialmente banco mySQL)

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gerenciamento-biblioteca
    DB_USERNAME=root
    DB_PASSWORD=

Realizar as configurações para envio de e-mail

    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=

Realizar a configuração da chave e do tempo de duração do token JWT. Ambos possuem um valor padrão mas é recomendavel que seja utilizado apenas para desenvolvimento.

    JWT_TOKEN_DURATION=
    JWT_SECRET=

Gerar o application key

    php artisan key:generate

Rodar o migrations pra criar as tabelas

    php artisan migrate

Rodar o seed pra alimentar o banco com os autores, livros e criar o usuario admin

    php artisan db:seed

## Testando o projeto

Iniciar o servidor local

    php artisan serve

Para processar a fila de emails o seguinte comendo deve ser executado

    php artisan queue:work

O sistema possui um usuario admin que pode gerenciar a biblioteca

    Login: admin@admin.com
    Senha: 123456

## Documentação

A api possui uma documentação feita usando o apiDoc e uma collection do postman

    A documentação pode ser encontrada na pasta apidoc/index.html

[Postman Collection](GerenciamentoBiblioteca.postman_collection.json)

[Postman Environment](GerenciarBiblioteca.postman_environment.json)
