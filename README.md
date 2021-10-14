# EAD PLATAFORM
  - Essa aplicação é um overview do Framework Laravel e das principais funcionalidades que utilizaremos para o desenvolvimento do Projeto Integrador Univesp.
  ![landing](/public/screenshots/landing.png)

## REQUISITOS
  - XAMPP (https://www.apachefriends.org/pt_br/index.html)
    - PHP >= 7.2v
    - MySQL
  - Composer (https://getcomposer.org/)
  - Git (https://git-scm.com/downloads)

## CLONANDO UMA APLICAÇÃO DO GITHUB
  - Para fazer o clone da aplicação do github é bem fácil:
    - basta acessar o repositório
    - copiar o código,
    - fazer o git clone na sua máquina.
  - Com a aplicação na sua máquina, você irá precisar instalar as dependências da aplicação. Para isso, basta executar o comando:
    - ``` composer install ```
  - Depois das dependências instaladas, você irá criar o seu arquivo ``` .env ```.
    - Para criar esse arquivo, você irá copiar os dados do ``` .env.example ``` irá alterar as configurações do banco de dados, como fizemos na seção de configuração de banco, e irá execytar i comando abaixo para gerar a chave da aplicação:
      - ``` php artisan key:generate ```
  - [video-clonando-app-do-github](https://watch.screencastify.com/v/YjoVmlLj0yT1GrKC5AEr)
  
## EXECUTANDO PROJETO
  - Com a base do projeto instalada no passo anterior, e com o arquivo aberto no Visual Studio Code como pasta raiz, podemos executar o comando de start do laravel:
    - ``` php artisan serve ```   
  - [video-startando-o-projeto](https://watch.screencastify.com/v/x4fMa459P9zBL16iN1mn)

## CONFIGURANDO BANCO DE DADOS
  - A configuração do banco de dados acontece dentro do arquivo .env, e toda a criação de tabelas são controladas pelas migrations.
  - [video-configurando-banco-de-dados](https://watch.screencastify.com/v/weRMz3N3xfAW5rEVpjDo)

## RESPONSIVIDADE DO SITE
  - [video-responsive](https://watch.screencastify.com/v/mnRCqOEcyI7BJAliPGL7)
  
## REFERENCIAS
[Laravel-Documentation](https://laravel.com/docs/8.x)