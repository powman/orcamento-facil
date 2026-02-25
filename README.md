# Gerador de Orçamentos

Sistema completo de geração de orçamentos em Laravel 11 com suporte a multi-empresa, Livewire e MariaDB.

## Stack Técnica

- **Laravel 11**
- **Livewire 3**
- **MariaDB**
- **TailwindCSS** (via Vite)
- **Laravel Breeze** (autenticação)

## Instalação

```bash
git clone <url-do-repositorio>
cd <pasta>
cp .env.example .env

# Configure o banco de dados no .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

composer install
npm install && npm run build
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Acesse: http://localhost:8000

## Credenciais de Acesso (Seeders)

| Empresa        | E-mail                     | Senha    |
|----------------|----------------------------|----------|
| Gesso Pro      | admin@gessopro.com.br      | password |
| Silva Reformas | admin@silvareformas.com.br | password |

## Funcionalidades

- **Dashboard** com estatísticas e últimos orçamentos
- **Orçamentos** — CRUD completo via Livewire com cálculo em tempo real
- **Clientes** — CRUD básico
- **Configurações da Empresa** — dados, logo e lista de serviços
- **Impressão/PDF** — layout A4 com botão `window.print()`
- **Multi-empresa** — isolamento total de dados entre empresas
- Numeração automática `ORÇ-{ANO}-{SEQ}` por empresa
