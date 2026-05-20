# 📋 Resumo Técnico Completo — Pastoral Care
> Documento gerado em 20/05/2026 — Para continuação por outra IA

---

## 🎯 Objetivo do Projeto

Sistema web interno estilo "rede social" para organizações religiosas realizarem gestão de atendimentos e assistência espiritual. Voluntários registram atendimentos de assistidos (beneficiários), coordenadores supervisionam, comentam e acompanham em tempo real.

---

## 🏗️ Arquitetura

### Stack Completa
| Camada | Tecnologia | Versão |
|---|---|---|
| Backend | Laravel | 12.x |
| Frontend reativo | Livewire | 3.x |
| Painel admin | Filament | 3.3.50 |
| Banco de dados | MySQL | 8.4 |
| Cache/Filas | Redis | alpine |
| Auth/RBAC | Spatie Permission + Filament Shield | latest |
| Ambiente | Docker (Laravel Sail) | latest |
| Assets | Vite + Tailwind CSS | v4 |
| PHP | PHP | 8.5.5 |

### Ambiente Docker (Sail)
```
Containers:
- pastoral-care-laravel.test-1 → porta 80 (app) e 5173 (vite)
- pastoral-care-mysql-1        → porta 3306
- pastoral-care-redis-1        → porta 6379
```

### Diretório do Projeto
```
/home/moraws/pastoral-care/
```

### Repositório Git
```
https://github.com/prmoraws/pastoral-care.git
branch: main
```

---

## 👥 Papéis e Acesso

| Papel (Spatie) | Nome Real | Acesso |
|---|---|---|
| `super_admin` | Super Admin/Moderador | Irrestrito — sistema, configs, auditoria |
| `editor` | Coordenador | Feed, painel (assistidos + voluntários), gerar convites para voluntários |
| `author` | Voluntário | Apenas feed próprio, sem acesso ao /admin |

### Usuário Super Admin atual
```
Email: admin@pastoralcare.com
Senha: password123
URL painel: http://localhost/admin
```

---

## 🗄️ Banco de Dados — Tabelas

### Tabelas principais
```sql
users                    -- Autenticação unificada (todos os papéis)
perfil_voluntarios       -- Dados estendidos do voluntário (condicao, contato, avatar, igreja, ativo, registration_token)
perfil_coordenadores     -- Dados estendidos do coordenador (cargo, contato, avatar, igreja)
assistidos               -- Registros de atendimentos (ex-atendimentos, ex-pessoas)
atualizacoes             -- Atualizações incrementais por assistido
curtidas                 -- Curtidas nos assistidos (atendimento_id)
comentarios              -- Comentários nos assistidos (atendimento_id)
atualizacao_curtidas     -- Curtidas nas atualizações
atualizacao_comentarios  -- Comentários nas atualizações
notificacoes             -- Notificações in-app (table: notificacoes — ATENÇÃO ao plural)
convites                 -- Tokens de convite (papel, token, usado, expires_at)
audit_logs               -- Log de auditoria (acao, modelo, modelo_id, dados_anteriores, dados_novos)
voluntarios              -- Tabela legada (perfis antigos — pode ser ignorada)
blocos                   -- 21 blocos geográficos (populada via SQL)
regiaos                  -- 154 regiões vinculadas a blocos (populada via SQL)
igrejas                  -- Igrejas vinculadas a regiões (populada via SQL)
roles / permissions / model_has_roles / role_has_permissions -- Spatie
```

### Campos importantes de `assistidos`
```sql
id, user_id (FK users), nome_assistido, contato, endereco, bairro, cidade,
bloco_id (FK blocos), regiao_id (FK regiaos), igreja_id (FK igrejas),
foto, imagem, descricao, data_atendimento, ordem, curtidas_count, comentarios_count,
created_at, updated_at
```

### ATENÇÃO — Nomes de tabelas com plural irregular
```
notificacoes   → Model: Notificacao  (protected $table = 'notificacoes')
atualizacoes   → Model: Atualizacao  (protected $table = 'atualizacoes')
atualizacao_curtidas    → Model: AtualizacaoCurtida
atualizacao_comentarios → Model: AtualizacaoComentario
```

---

## 📁 Estrutura de Arquivos Relevante

### Models (`app/Models/`)
```
User.php                 -- Auth + papéis + relacionamentos
Assistido.php            -- ex-Atendimento (table: assistidos)
Atualizacao.php          -- table: atualizacoes
Comentario.php           -- comentários do post (atendimento_id)
Curtida.php              -- curtidas do post (atendimento_id)
AtualizacaoCurtida.php   -- curtidas da atualização
AtualizacaoComentario.php -- comentários da atualização
Notificacao.php          -- table: notificacoes
Convite.php              -- sistema de convites
AuditLog.php             -- log de auditoria
PerfilVoluntario.php     -- table: perfil_voluntarios
PerfilCoordenador.php    -- table: perfil_coordenadores
Bloco.php                -- blocos geográficos
Regiao.php               -- regiões (bloco_id FK)
Igreja.php               -- igrejas (regiao_id FK)
Voluntario.php           -- LEGADO (tabela voluntarios antiga)
```

### Livewire (`app/Livewire/`)
```
Feed.php                 -- Feed principal com filtros
CardAtendimento.php      -- Card do post (curtir, comentar, atualizar, editar comentário)
CardAtualizacao.php      -- Card da atualização (curtir, comentar, editar comentário)
NovoAtendimento.php      -- Modal de novo atendimento com cascata bloco/região/igreja
EditarPerfil.php         -- Edição de perfil fora do painel (voluntário/coordenador)
NotificacaoSininho.php   -- Sininho de notificações in-app
GerarConvite.php         -- Gerar links de convite
AceitarConvite.php       -- Formulário de aceite de convite
CardPessoa.php           -- LEGADO (não usado mais)
```

### Filament (`app/Filament/`)
```
Resources/
  UserResource.php          -- Gestão de usuários (super_admin apenas)
  VoluntarioResource.php    -- Lista users com papel author (coordenador vê, não edita)
  AtendimentoResource.php   -- Gestão de assistidos (model: Assistido)
  AuditLogResource.php      -- Log de auditoria (super_admin apenas)
Widgets/
  StatsOverview.php         -- Cartões: total assistidos, este mês, blocos, voluntários
  AssistidosPorBloco.php    -- Gráfico de barras por bloco
  AssistidosPorRegiao.php   -- Gráfico de linha top 10 regiões
Pages/
  FeedPage.php              -- Redireciona author para /feed
```

### Views (`resources/views/`)
```
layouts/
  app.blade.php         -- Layout principal (max-w-lg, navbar incluído)
  navigation.blade.php  -- Navbar com sininho, menu hamburguer, link painel
  guest.blade.php       -- Layout para páginas sem auth (convite)
livewire/
  feed.blade.php
  card-atendimento.blade.php
  card-atualizacao.blade.php
  novo-atendimento.blade.php  -- Modal bottom-sheet mobile
  editar-perfil.blade.php
  notificacao-sininho.blade.php
  gerar-convite.blade.php
  aceitar-convite.blade.php
perfil.blade.php          -- Página pública de perfil
convite.blade.php         -- Wrapper do AceitarConvite
convite-invalido.blade.php -- Página de convite expirado/inválido
```

---

## 🔑 Variáveis de Ambiente (.env)

```env
APP_NAME=Laravel
APP_ENV=local
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=pastoral_care
DB_USERNAME=sail
DB_PASSWORD=password
REDIS_HOST=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

---

## 💡 Decisões Técnicas Importantes

### 1. Autenticação unificada
Todos os usuários (super_admin, editor/coordenador, author/voluntário) estão na tabela `users`. Dados extras ficam em `perfil_voluntarios` e `perfil_coordenadores` — isso preserva compatibilidade com Filament Shield e Spatie Permission.

### 2. Tabela `assistidos` (ex-`atendimentos`)
A tabela foi renomeada de `atendimentos` para `assistidos` via migration. O model é `Assistido`. O resource Filament ainda se chama `AtendimentoResource` mas usa `$model = Assistido::class`.

### 3. Plural irregular no Laravel
Laravel não sabe pluralizar palavras em português. Todos os models com tabelas de plural irregular têm `protected $table = 'nome_correto'` explícito.

### 4. Notificações customizadas
Não usa o sistema de notificações nativo do Laravel. Usa tabela própria `notificacoes` com campo `data` (JSON) contendo: `autor`, `comentario`, `pessoa`.

### 5. Cascata Bloco → Região → Igreja
Implementada via Livewire com `wire:model.live` e propriedades computadas (`getRegioesProperty`, `getIgrejasProperty`). No Filament usa `->live()` com `->afterStateUpdated()` para reset dos campos dependentes.

### 6. Título automático do atendimento
Campo `ordem` (int) define o título: `ordem === 1` → "Atendimento - data", demais → "Atualização - data". Gerado pelo `AtendimentoObserver` no evento `creating`.

### 7. Convites com token
Tabela `convites` com `token` (48 chars random), `papel` (editor|author), `usado` (bool), `expires_at`. Expiração: 1 uso OU 7 dias. Super Admin convida editor; editor convida author.

### 8. Voluntário bloqueado do /admin
`canAccessPanel()` no model `User` retorna `false` para papel `author`. Voluntário só acessa `/feed`, `/meu-perfil` e `/perfil/{user}`.

---

## 🔄 Observers Registrados

```php
// app/Providers/AppServiceProvider.php
Assistido::observe(AtendimentoObserver::class);
// Define ordem automática e user_id no creating
```

---

## 🛣️ Rotas Principais (`routes/web.php`)

```php
GET  /              → redirect → /feed
GET  /feed          → Feed::class (auth)
GET  /perfil/{user} → view perfil (auth)
GET  /meu-perfil    → EditarPerfil::class (auth)
GET  /convites      → GerarConvite::class (auth)
GET  /convite/{token} → view convite ou convite-invalido (guest)
POST /logout        → logout (auth)
GET  /profile       → Breeze ProfileController (auth)
```

---

## 🎨 Design System

```css
Gradiente principal: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045)
Cor primária: #833ab4 (purple)
Cor secundária: #fd1d1d (red)
Cor terciária: #fcb045 (orange)
Max width feed: max-w-lg (512px)
Border radius cards: rounded-lg / rounded-xl / rounded-2xl
Font: sistema (sans-serif)
```

---

## ⚠️ Pendências e Bugs Conhecidos

1. **Botão "Editar comentário" inconsistente** — aparece apenas para o usuário dono do comentário. Verificar se `Auth::id()` está correto no contexto Livewire para todos os papéis.

2. **Campo `condicao` duplicado** — existe em `users.condicao` (legado) e `perfil_voluntarios.condicao` (correto). O campo em `users` pode ser removido via migration futura.

3. **Campo `avatar` duplicado** — existe em `users.avatar` (legado) e `perfil_voluntarios.avatar` / `perfil_coordenadores.avatar` (correto). A navbar e o feed leem de lugares diferentes — precisa unificar.

4. **Tabela `voluntarios` legada** — existe no banco mas não é mais usada. Pode ser removida.

5. **`AtendimentoResource`** — o nome do resource não foi renomeado para `AssistidoResource`. Funciona mas é inconsistente.

6. **Filtros do feed para coordenador** — filtro por bloco/região ainda não implementado no feed (apenas por voluntário e data).

7. **Dashboard do coordenador** — widgets aparecem apenas para super_admin. Coordenador vê dashboard vazio. Falta atribuir permissão `widget_StatsOverview` ao papel `editor`.

8. **Título "Atualização"** — atendimentos criados antes da implementação do Observer têm `ordem = 0` e mostram "Atualização" em vez de "Atendimento". Fix: `Assistido::where('ordem', 0)->update(['ordem' => 1])`.

9. **Upload de imagens** — storage link deve ser criado após clonar: `./vendor/bin/sail artisan storage:link`.

10. **Mês em inglês no dashboard** — "Registrados em May 2026". Falta configurar `APP_LOCALE=pt_BR` e `Carbon::setLocale('pt_BR')`.

---

## 🚀 Próximos Passos Sugeridos

### Alta prioridade
- [ ] Corrigir avatar: unificar leitura do avatar do usuário logado (usar perfil correto por papel)
- [ ] Adicionar filtro por Bloco e Região no feed do coordenador
- [ ] Corrigir widgets do dashboard para coordenador (atribuir permissões)
- [ ] Implementar soft delete em `assistidos` (campo `deleted_at`)
- [ ] Página dedicada de notificações (além do sininho)

### Média prioridade
- [ ] Remover campo `condicao` e `avatar` legados da tabela `users`
- [ ] Remover tabela `voluntarios` legada
- [ ] Renomear `AtendimentoResource` para `AssistidoResource`
- [ ] Configurar locale pt_BR no Carbon
- [ ] Implementar reatribuição de assistido entre voluntários (pelo coordenador)
- [ ] Adicionar paginação às atualizações dentro do card

### Baixa prioridade
- [ ] Dashboard do voluntário no feed (total de seus assistidos, curtidas recebidas)
- [ ] Exportação de relatórios (PDF/Excel) por bloco/região
- [ ] Implementar filas (queue) para notificações
- [ ] Testes automatizados (Feature tests para Feed e Convites)
- [ ] README com screenshots

---

## 🧩 Padrões Utilizados

| Padrão | Onde |
|---|---|
| Observer | `AtendimentoObserver` — ordem automática no `creating` |
| Policy | `PessoaPolicy`, `AtendimentoPolicy`, `ComentarioPolicy`, `CurtidaPolicy` |
| Repository-like | Queries encapsuladas nos métodos do Feed e Widgets |
| Computed Properties | `getRegioesProperty()`, `getIgrejasProperty()` no Livewire |
| Accessor | `getTituloAttribute()`, `getLabelComentarioAttribute()` nos Models |
| Gate/Policy via Shield | Filament Shield gerencia permissões por resource automaticamente |
| Soft Deletes | Apenas em tabela legada `pessoas` (não em `assistidos` ainda) |
| Counter Cache | `curtidas_count`, `comentarios_count`, `atendimentos_count` desnormalizados |
| Token Pattern | `Convite::gerar()` — static factory method |

---

## 🔧 Comandos Úteis

```bash
# Subir ambiente
./vendor/bin/sail up -d

# Rodar migrations
./vendor/bin/sail artisan migrate

# Limpar caches
./vendor/bin/sail artisan view:clear && ./vendor/bin/sail artisan cache:clear

# Regenerar permissões Shield
./vendor/bin/sail artisan shield:generate --all
./vendor/bin/sail artisan shield:super-admin --user=1

# Compilar assets
./vendor/bin/sail npm run build

# Acessar MySQL como root
./vendor/bin/sail exec mysql mysql -u root -ppassword pastoral_care

# Tinker
./vendor/bin/sail artisan tinker
```

---

## 📌 Contexto para Continuação

A IA que continuar este projeto deve:

1. **Clonar** `https://github.com/prmoraws/pastoral-care.git`
2. **Seguir** os passos de instalação do README.md
3. **Ler** este documento antes de qualquer implementação
4. **Verificar** as pendências antes de adicionar novas features
5. **Manter** o padrão de nomenclatura em português (models, variáveis, labels)
6. **Testar** sempre com os 3 papéis: super_admin, editor (coordenador), author (voluntário)
7. **Fazer commit** após cada etapa concluída e validada

### Credenciais de teste atuais
```
Super Admin: admin@pastoralcare.com / password123
Coordenador: lider@pastoralcare.com (criado via convite)
Voluntário:  tv@pr.universal.org.br (Lucas, criado via convite)
```

---

*Documento gerado automaticamente. Créditos: J.M. Moraes N. — 2026*
