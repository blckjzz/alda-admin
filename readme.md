# Alda admin-panel


# Technology Stack

 - `PHP (^7.1.3)`
 - `Laravel (^5.6)`
 - `Voyager admin (^1.1)`
 - `Postgres SQL (^9.6.x)`
 - [Composer](https://getcomposer.org/download/)
 - [Apache](https://phpraxis.wordpress.com/2016/08/02/steps-for-configuring-laravel-on-apache-http-server/) ou [nginx](https://www.digitalocean.com/community/tutorials/how-to-deploy-a-laravel-application-with-nginx-on-ubuntu-16-04) server`


## Installation process
 No seu terminal digite os `seguintes comandos:
1.   ` git clone https://github.com/se3k/alda-admin`
2.   ` cd alda-admin`
3.   ` composer install` (instalando todas dependências do projeto)

## Setting up .env

Na pasta do projeto copie o arquivo `.env.exemple` e ajuste as todas variáveis.

    cd your-local-folder/project-folder
    cp .env.exemple  .env

## Setting up .env

Você precisa "setar" as seguintes variáveis:
 	DB_HOST=`your-hostname/connection`
	 DB_PORT=`your-database-port (default 5432)`  
	 DB_DATABASE=`your-database`
	 DB_USERNAME=`your-username`  
	 DB_PASSWORD=`your-password`
	 APP_ENV=`production` (aqui serão omitidos todos quais quer debug da aplicação)
	 LOCALSTORAGE_PATH=`/local/path/storage/private`
	 FILESYSTEM_DRIVER=`production`


##  Settup do armazenamento local

O caminho real de armazenamento será setado através da variável `LOCALSTORAGE_PATH`, onde deverá ser definido um diretório qualquer com estrutura `/storage/private`.

No terminal execute:

    ln -s /home/you-user/your-path/storage/private /home/your-user/alda-admin/public/my-files

O projeto laravel irá realizar o link simbólico entre o `/public/my-files` e o real local de armazenamento. Assim a aplicação poderá disponibilizar imagens e outros arquivos dentro da aplicação.

2) Executar passos abaixo apenas se armazenamento for local na pasta do projeto.

1. criar diretório dentro da pasta `/storage/app/private`

No terminal: 

     mkdir your-project/alda-admin/storage/app/private
	 ln -s /home/you-user/your-path/storage/private /home/your-user/alda-admin/public/my-files

## Antes de iniciar a aplicação

 1. Restaure o backup fornecido (o admin só irá funcionar com as devidas tabelas no banco)
 2. Crie um usuário admin através do comando: `php artisan voyager:admin your@email.com --create`
 3. Siga os passos para adicionar uma  senha
 4. Pronto, a aplicação está pronta para ser acessada na url especificada.
 5. para subir a aplicação ainda no terminal execute: `php artisan serve`
 6 . Acesse a aplicação em: `localhost:8080/painel/`
 7 . Faça login com as credenciais criadas no passo 2 e 3.

## Scheduler

O projeto consta com uma rotina que precisa ser executada 1x ao dia.

Comando
`php artisan agenda:update_status`

Resultado será a atualização do flag booleano de reunio realizada para agendas que tem uma data inferior ao dia atual.


