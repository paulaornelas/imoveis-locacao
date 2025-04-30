# 🏡 Sistema de Imóveis e Proprietários - Laravel API

## Pré-requisitos

Antes de começar, garanta que você tem instalado em sua máquina:

- [PHP 8.1+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)
- [Git](https://git-scm.com/)
- [Wamp](https://www.wampserver.com/en/)
- (Opcional) [Laravel Installer](https://laravel.com/docs/10.x/installation)

## Rodar o projeto localmente

### 1. Clone o repositório
` git clone https://github.com/paulaornelas/imoveis-locacao.git
> cd imoveis-locacao

### 2. Instale as dependências PHP
> composer install

### 3. Copie a configuração de ambiente
> cp .env.example .env

### 4. Gere a chave da aplicação
> php artisan key:generate

### 5. Configure o banco de dados
No arquivo .env, configure as seguintes variáveis:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_imoveis
DB_USERNAME=root
DB_PASSWORD=
