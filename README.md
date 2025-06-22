# 🎬 Laravel Movie API

Esta é uma API RESTful construída com Laravel para autenticação de usuários e gerenciamento de filmes. Usuários autenticados podem cadastrar, visualizar, atualizar e deletar seus próprios filmes.

---

## 📦 Requisitos

- PHP 8.x
- Composer
- Docker / Docker Compose
- Laravel 10+
- Banco de dados configurado MySQL
- JWT para autenticação via token
- [Extra] Php MyAdmin 

---

## 🚀 Executar projeto

```bash
    docker-compose up -d
```
---

## 🔐 Autenticação

A API utiliza autenticação via token (JWT). Após o `signup` ou `login`, inclua o token nos headers das requisições protegidas:

```
Authorization: Bearer {token}
```

---

## 📚 Endpoints
#### http://localhost:8000/api

### ✅ Health Check
`GET /`

> Retorna um JSON com status da API.

---

### 👤 Autenticação

| Método | Endpoint        | Descrição                     |
|--------|------------------|-------------------------------|
| POST   | `/signup`        | Registro de novo usuário      |
| POST   | `/login`         | Login com e-mail e senha      |
| POST   | `/logout`        | Logout e invalida o token     |
| POST   | `/refresh`       | Renova o token JWT            |
| GET    | `/me`            | Retorna dados do usuário logado *(requer token)* |
| POST   | `/update-me`     | Atualiza dados do usuário *(requer token)* |

---

### 🎥 Filmes (Requer Autenticação)

| Método | Endpoint            | Descrição                          |
|--------|----------------------|------------------------------------|
| GET    | `/movies`            | Lista todos os filmes do usuário   |
| GET    | `/movies/{id}`       | Detalhes de um filme específico    |
| POST   | `/movies`            | Cadastra um novo filme             |
| PUT    | `/movies/{id}`       | Atualiza um filme existente        |
| DELETE | `/movies/{id}`       | Remove um filme                    |

---

## 📂 Uploads

Imagens de perfil são salvas em:  
```
storage/app/public/user_images/
```

Acesso público via URL:
```
http://localhost:8000/storage/user_images/{nome_da_imagem}
```

---

## 📎 Exemplo de resposta de erro

```json
{
  "message": "Erro de validação.",
  "errors": {
    "email": ["O campo e-mail é obrigatório."]
  }
}
```

---
## 🔐 Acesso ao phpMyAdmin

- **URL de acesso**: [http://localhost:8080](http://localhost:8080)
- **Usuário**: `root`
- **Senha**: `root`

## 🛠️ Criando o banco de dados `app_test`

Após acessar o phpMyAdmin:

1. Clique em "**SQL**" no menu superior.
2. Cole e execute o seguinte comando:

```sql
CREATE DATABASE app_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Pronto! O banco de dados `app_test` estará criado e disponível para uso.

---
##  🧪 Testes
#### ⚠️ Necessário criar o banco app_test, veja como mais abaixo

```bash
  php artisan migrate:fresh --env=testing

  php artisan test
```

### ⚠️ Observações

- Certifique-se de que os contêineres estão rodando corretamente.
---

## Importando as Rotas da API no Postman

Este guia explica como importar o arquivo de coleções do Postman com as rotas da sua API.

### 📥 Passo a Passo para Importar

1. **Abra o Postman** (versão desktop ou web).
2. No menu lateral esquerdo, clique em **"Collections"**.
3. Clique no botão **"Import"** (ou no ícone de "+" com seta).
4. Selecione a aba **"Upload Files"**.
5. **Localize e selecione o arquivo JSON** `api_manager_movies.json` que está na raiz do projeto.
6. Clique em **"Import"**.

Pronto! Agora você verá todas as rotas organizadas dentro do Postman, prontas para uso.

---

### 📌 Não Esqueça

- Configure a variável `{{base_url}}` com `http://localhost:8000/api`.
- Configure a variável `{{token}}`.

---

Use nas rotas do Postman como:

```
{{base_url}}/login
{{base_url}}/movies
```

---

Boas requisições! 🚀


## 🧾 Licença

MIT
