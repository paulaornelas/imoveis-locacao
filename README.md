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
**Exemplo de corpo (JSON):**
```json
{
  "endereco": "Rua Joaquim, 17",
  "valor": 250000.00,
  "proprietario_id": 1
}
#### Atualizar imóvel  
`PUT /api/imoveis/{id}`

Exemplo de corpo (JSON):

```json
{
  "endereco": "Rua Nova, 22",
  "valor": 350000.00,
  "proprietario_id": 2
}
