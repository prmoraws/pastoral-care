<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo"/>
</p>

<h1 align="center">Pastoral Care</h1>

<p align="center">
  <strong>Sistema de Gestão de Atendimentos e Assistência Espiritual</strong><br/>
  Plataforma interna estilo rede social para registro, acompanhamento e supervisão de assistidos.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel" />
  <img src="https://img.shields.io/badge/Livewire-3.x-pink?style=flat-square" />
  <img src="https://img.shields.io/badge/Filament-3.x-orange?style=flat-square" />
  <img src="https://img.shields.io/badge/PHP-8.5-blue?style=flat-square&logo=php" />
  <img src="https://img.shields.io/badge/MySQL-8.4-blue?style=flat-square&logo=mysql" />
  <img src="https://img.shields.io/badge/Docker-Sail-2496ED?style=flat-square&logo=docker" />
  <img src="https://img.shields.io/badge/license-MIT-green?style=flat-square" />
</p>

---

## 📖 Sobre o Sistema

O **Pastoral Care** é uma plataforma web interna desenvolvida para organizações religiosas que realizam trabalho social e assistência espiritual. O sistema permite que voluntários registrem atendimentos com dados completos dos assistidos, acompanhem o histórico de cada caso e recebam supervisão dos coordenadores em tempo real — tudo em uma interface moderna e intuitiva inspirada no Instagram.

O sistema foi projetado para facilitar a comunicação entre voluntários e coordenadores, garantindo rastreabilidade, privacidade e controle de acesso granular por papel.

---

## ✨ Funcionalidades Principais

### 📱 Feed Social (estilo Instagram)
- Feed de atendimentos ordenado por data
- Cards com foto, dados do assistido e descrição
- Curtidas e comentários por atendimento
- Atualizações incrementais por card (com curtidas e comentários próprios)
- "Leia mais" para textos longos
- Sininho de notificações em tempo real
- Filtros por voluntário, nome e data (para coordenadores)

### 👥 Controle de Acesso por Papel
| Papel | Acesso |
|---|---|
| **Super Admin** | Acesso irrestrito ao sistema, configurações e auditoria |
| **Coordenador (Editor)** | Visualiza todos os assistidos, comenta, curte, acessa painel |
| **Voluntário (Author)** | Registra e gerencia apenas seus próprios atendimentos |

### 🗂️ Gestão de Atendimentos
- Cadastro completo do assistido: nome, foto, endereço, bairro, cidade e contato
- Registro de atendimentos com descrição, data e imagem
- Atualizações incrementais vinculadas ao atendimento original
- Título automático: "Atendimento" (primeiro) e "Atualização" (demais)
- Edição e exclusão com controle de autoria

### 🔐 Sistema de Convites
- Geração de links únicos com token de 48 caracteres
- Expiração automática: 1 uso ou 7 dias
- Super Admin convida Coordenadores; Coordenadores convidam Voluntários
- Página de cadastro personalizada por tipo de convite
- Tratamento de convites inválidos ou expirados

### 👤 Perfis de Usuário
- **Perfil do Voluntário**: condição (Bispo, Pastor, Esposa, Obreiro, Evangelista, Líder de Grupo, Membro), contato, Igreja/Região/Bloco, avatar
- **Perfil do Coordenador**: cargo, contato, Igreja/Região/Bloco, avatar
- Página pública de perfil com estatísticas de atendimentos, curtidas e comentários
- Edição de perfil e alteração de senha sem acesso ao painel admin

### 🏛️ Painel Administrativo (Filament)
- Gestão de usuários com filtros por papel
- Listagem de assistidos e voluntários
- Controle de acesso baseado em permissões (Filament Shield + Spatie Permission)
- Log de auditoria: registra quem editou ou excluiu registros e quando

### 📊 Auditoria
- Log completo de ações (criou, editou, excluiu)
- Dados anteriores e novos armazenados em JSON
- Visível apenas para Super Admin

---

## 🏗️ Arquitetura Técnica

### Stack
| Camada | Tecnologia |
|---|---|
| Backend | Laravel 12 (PHP 8.5) |
| Frontend reativo | Livewire 3 |
| Painel admin | Filament 3 |
| Banco de dados | MySQL 8.4 |
| Cache / Filas | Redis |
| Autenticação | Laravel Breeze + Spatie Permission |
| RBAC | Filament Shield |
| Ambiente | Docker (Laravel Sail) |
| Assets | Vite + Tailwind CSS v4 |

### Estrutura do Banco de Dados
```
users                    → Autenticação unificada (todos os papéis)
perfil_voluntarios       → Dados estendidos do voluntário
perfil_coordenadores     → Dados estendidos do coordenador
assistidos               → Registros de atendimentos (ex-atendimentos)
atualizacoes             → Atualizações incrementais por atendimento
curtidas                 → Curtidas nos atendimentos
comentarios              → Comentários nos atendimentos
atualizacao_curtidas     → Curtidas nas atualizações
atualizacao_comentarios  → Comentários nas atualizações
notificacoes             → Notificações in-app
convites                 → Tokens de convite com expiração
voluntarios              → Tabela legada (perfis)
audit_logs               → Log de auditoria de ações
roles / permissions      → Controle de acesso (Spatie)
```

---

## 🚀 Instalação

### Pré-requisitos
- Docker Desktop com WSL2
- PHP 8.2+ (para rodar composer localmente)
- Composer

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/prmoraws/pastoral-care.git
cd pastoral-care

# 2. Instale as dependências
composer install

# 3. Configure o ambiente
cp .env.example .env

# 4. Suba o ambiente Docker
./vendor/bin/sail up -d

# 5. Gere a chave da aplicação
./vendor/bin/sail artisan key:generate

# 6. Crie o banco de dados
./vendor/bin/sail exec mysql mysql -u root -ppassword -e \
  "CREATE DATABASE IF NOT EXISTS pastoral_care CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; \
   GRANT ALL PRIVILEGES ON pastoral_care.* TO 'sail'@'%'; FLUSH PRIVILEGES;"

# 7. Rode as migrations
./vendor/bin/sail artisan migrate

# 8. Publique as permissões (Filament Shield)
./vendor/bin/sail artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan shield:install
./vendor/bin/sail artisan shield:generate --all

# 9. Crie o Super Admin
./vendor/bin/sail artisan tinker
# Dentro do tinker:
\App\Models\User::create(['name' => 'Super Admin', 'email' => 'admin@pastoral.com', 'password' => bcrypt('password')]);
exit
./vendor/bin/sail artisan shield:super-admin --user=1

# 10. Link de storage
./vendor/bin/sail artisan storage:link

# 11. Compile os assets
./vendor/bin/sail npm install && ./vendor/bin/sail npm run build
```

### Acesso
| URL | Descrição |
|---|---|
| `http://localhost/feed` | Feed principal |
| `http://localhost/admin` | Painel administrativo |
| `http://localhost/login` | Login |
| `http://localhost/convites` | Gerar convites (auth) |

---

## 📁 Estrutura de Diretórios Relevante

```
app/
├── Filament/Resources/     → Resources do painel (Filament)
├── Livewire/               → Componentes reativos (Feed, Cards, Convites)
├── Models/                 → Eloquent Models
├── Observers/              → Observers (ordem automática de atendimentos)
├── Policies/               → Políticas de acesso
└── Providers/              → Service Providers (Gates, Observers)

resources/views/
├── layouts/                → Layouts base (app, guest, navigation)
├── livewire/               → Views dos componentes Livewire
├── perfil.blade.php        → Página pública de perfil
├── convite.blade.php       → Formulário de aceite de convite
└── convite-invalido.blade.php
```

---

## 🔒 Segurança

- Autenticação via Laravel Breeze (sessão + CSRF)
- RBAC com Spatie Permission + Filament Shield
- Policies para controle granular por recurso
- Tokens de convite gerados com `Str::random(48)`
- Convites com expiração automática (1 uso ou 7 dias)
- Log de auditoria para ações críticas
- Soft delete para preservação de histórico

---

## 📸 Capturas de Tela

> Feed principal, perfil de voluntário e painel administrativo disponíveis na pasta `/docs/screenshots` (em breve).

---

## 🤝 Créditos e Autoria

Desenvolvido por **J.M. Moraes N.** como solução interna para gestão de atendimentos e assistência espiritual em organizações religiosas.

> *"Tecnologia a serviço do cuidado humano."*

---

## 📄 Licença

Este projeto é software proprietário. Todos os direitos reservados © 2026 J.M. Moraes N.

---

<p align="center">
  Feito com ❤️ usando <a href="https://laravel.com">Laravel</a>, <a href="https://livewire.laravel.com">Livewire</a> e <a href="https://filamentphp.com">Filament</a>
</p>
