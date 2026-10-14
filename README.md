# Aula Alfa Laravel – Recuperação de senha

Projeto Laravel (PHP 8.4, SQLite, AdminLTE via Vite) com cadastro de usuário, login e fluxo de recuperação de senha.

## Requisitos

- PHP 8.4+ e Composer
- Node.js e npm

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate        # o banco é SQLite (database/database.sqlite)
npm install
```

Depois, em **dois terminais**:

```bash
npm run dev          # terminal 1: assets (Vite)
php artisan serve    # terminal 2: servidor em http://localhost:8000
```

Atalho: `composer setup` faz a instalação e `composer dev` sobe tudo junto.

## Rotas principais

| URL | Descrição |
|---|---|
| `/register` | Cadastro de usuário |
| `/login` | Login |
| `/forgot-password` | Etapa 1: informar o e-mail |
| `/verify-code` | Etapa 2: verificar código |
| `/reset-password` | Etapa 3: definir nova senha |
| `/admin/users` | Lista de usuários (destino após o login) |

## Fluxo de recuperação de senha

1. Em `/forgot-password`, informe o e-mail de um usuário cadastrado.
2. Em `/verify-code`, digite o código. **Apenas para teste, qualquer caractere é aceito.**
3. Em `/reset-password`, informe a nova senha (mínimo 8 caracteres) e a confirmação.
4. Você é redirecionado para `/login` e já pode entrar com a nova senha.

As etapas 2 e 3 só abrem depois da etapa anterior (o controle é feito pela sessão).

