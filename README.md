# 🏡 Sistema de Imóveis e Proprietários – Laravel API

API REST para cadastro, consulta, atualização, remoção e filtragem de imóveis e seus proprietários.

---

## 📋 Pré-requisitos

- [PHP 8.1+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)
- [Git](https://git-scm.com/)
- [WAMP](https://www.wampserver.com/en/) (ou ambiente similar)
- (Opcional) [Laravel Installer](https://laravel.com/docs/10.x/installation)

---

## 🚀 Rodando o projeto localmente

1. **Clone o repositório**
    ```bash
    git clone https://github.com/paulaornelas/imoveis-locacao.git
    cd imoveis-locacao
    ```

2. **Instale as dependências PHP**
    ```bash
    composer install
    ```

3. **Configure as variáveis de ambiente**
    ```bash
    cp .env.example .env
    ```

4. **Gere a chave da aplicação**
    ```bash
    php artisan key:generate
    ```

5. **Configure o banco de dados**  
    Abra o arquivo `.env` e ajuste as variáveis:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=api_imoveis
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Crie a base de dados**  
    No MySQL, crie o banco `api_imoveis` (via phpMyAdmin ou CLI).

7. **Rode as migrations e seeders**
    ```bash
    php artisan migrate --seed
    # ou, para um reset total no banco:
    php artisan migrate:fresh --seed
    ```

8. **Inicie o servidor**
    ```bash
    php artisan serve
    ```
    Acesse a API: [http://localhost:8000](http://localhost:8000)

9. **(Opcional) Execute os testes**
    ```bash
    php artisan test
    # Para executar somente os testes de imóveis:
    php artisan test --filter=ImovelControllerTest
    ```

---

## 📚 Rotas da API

### 📦 Imóveis

#### Listar todos os imóveis  
**GET** `/api/imoveis`

#### Visualizar imóvel por ID  
**GET** `/api/imoveis/{id}`

#### Criar novo imóvel  

**POST** `/api/imoveis`  
#### Atualizar imóvel  
`PUT /api/imoveis/{id}`

Exemplo de corpo (apenas os campos):

- endereco: Rua Nova, 22
- valor: 350000.00
- proprietario_id: 2

#### Remover imóvel  
`DELETE /api/imoveis/{id}`

#### Filtrar imóveis  
`GET /api/imoveis/filter` + parâmetros de busca

Parâmetros disponíveis:
- valor_minimo: Valor mínimo do imóvel (opcional)
- valor_maximo: Valor máximo do imóvel (opcional)
- cidade: Trecho do endereço (cidade) que deve conter no campo "endereco" (opcional)

Exemplos de requisições:
- Buscar todos em "Uberlândia":  
  `/api/imoveis/filter?cidade=Uberlândia`
- Buscar por cidade e faixa de valor:  
  `/api/imoveis/filter?cidade=Lake Lomaton&valor_minimo=10000`
- Buscar imóveis até 500 mil:  
  `/api/imoveis/filter?valor_maximo=500000`

---

### 👤 Proprietários

#### Listar todos os proprietários  
`GET /api/proprietarios`

#### Visualizar proprietário por ID  
`GET /api/proprietarios/{id}`

#### Criar novo proprietário  
`POST /api/proprietarios`

Exemplo de corpo (apenas os campos):

- nome: Maria da Silva
- email: maria.silva@email.com

#### Atualizar proprietário  
`PUT /api/proprietarios/{id}`

Exemplo de corpo (apenas os campos):

- nome: João Souza
- email: joao@email.com

#### Remover proprietário  
`DELETE /api/proprietarios/{id}`

---

## 🔎 Detalhes do filtro de imóveis (`/api/imoveis/filter`)

- A filtragem de cidade ocorre por parte do endereço (o parâmetro `cidade` é um trecho do campo "endereco").
- O valor passado para `cidade` não precisa ser exato; basta estar contido no texto do endereço.
- Os filtros de valor e cidade podem ser combinados.

Exemplo:  
Buscar imóveis que tenham “Lake Lomaton” no endereço e valor acima de 50000:

