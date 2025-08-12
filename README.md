<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Como Excutar o APP em ambiente de desenvolvimento após clonar o repositório:

Resumo e Ordem de Execução Recomendada
    
    Ao clonar um projeto Laravel pela primeira vez, a ordem ideal para começar a trabalhar é:

1. Instalar as dependências do Composer:

    Bash

    composer install
    (Essencial para que o projeto funcione).

2. Configurar o arquivo .env:

    Copie o arquivo .env.example para .env.

    cp .env.example .env

3, Altere as credenciais do banco de dados para o seu ambiente local (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

    Gerar a chave de aplicação:

    Bash

    php artisan key:generate
    (Essencial para que o Laravel funcione corretamente).

4. Executar as migrações:

    Bash

    php artisan migrate
    (Isso irá criar todas as tabelas necessárias no seu banco de dados).

5. Rodar os seeders (opcional, mas recomendado):

    Bash

    php artisan db:seed
    (Isso irá popular o seu banco de dados com dados de teste, permitindo que você navegue pela aplicação e teste as funcionalidades sem precisar cadastrar tudo manualmente).

Seguindo esses passos, seu projeto estará configurado e pronto para ser executado com o comando php artisan serve.