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
3.   ` php artisan install` (instalando todas dependências do projeto)

## Setting up .env

Você precisa "setar" as seguintes variáveis:
 1. DB_HOST=`your-hostname/connection`
 2. DB_PORT=`your-database-port (default 5432)`  
 3. DB_DATABASE=`your-database`
 4. DB_USERNAME=`your-username`  
 5. DB_PASSWORD=`your-password`
 6. APP_ENV=`production` (aqui serão omitidos todos quais quer debug da aplicação)

## Antes de iniciar a aplicação

 1. Restaure o backup fornecido (o admin só irá funcionar com as devidas tabelas no banco)
 2. Crie um usuário admin através do comando: 
		 `php artisan voyager:admin your@email.com --create`
 3. Siga os passos para adicionar uma  senha
 4. Pronto, a aplicação está pronta para ser acessada na url especificada.
 5. Acesse a aplicação em: `https://yourapp-url.com/public/admin`
 6. Faça login com as credenciais criadas no passo 2 e 3.


