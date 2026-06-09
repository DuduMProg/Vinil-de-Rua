# 🎵 Vinil de Rua — Documentação Técnica

> Ecommerce de discos de vinil desenvolvido com foco em inovação, experiência musical e design moderno.

---

## 📋 Sumário

1. [Visão Geral](#visão-geral)
2. [Tecnologias Utilizadas](#tecnologias-utilizadas)
3. [Instalação e Configuração](#instalação-e-configuração)
4. [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
5. [Arquitetura e Estrutura de Pastas](#arquitetura-e-estrutura-de-pastas)
6. [Rotas](#rotas)
7. [Funcionalidades](#funcionalidades)
8. [Integrações Externas](#integrações-externas)
9. [Autenticação e Autorização](#autenticação-e-autorização)
10. [Painel Administrativo](#painel-administrativo)

---

## 1. Visão Geral

O **Vinil de Rua** é um ecommerce especializado em discos de vinil, desenvolvido para um público apaixonado por música e cultura urbana. O projeto oferece uma experiência de compra fluida e inovadora, com integração à API do Spotify para exibição de players de álbuns diretamente na página de cada produto.

**Principais diferenciais:**
- Player do Spotify integrado dinamicamente em cada produto
- Carrinho lateral (sidebar) sem redirecionamento de página
- Sistema de favoritos com sidebar interativa
- Desconto automático por tag de oferta
- Histórico de produtos e categorias vistos recentemente
- Painel administrativo completo com gráficos e gestão de pedidos

---

## 2. Tecnologias Utilizadas

| Camada | Tecnologia |
|--------|-----------|
| Backend | PHP 8.4 + Laravel 13 |
| Frontend | Blade + CSS puro + JavaScript vanilla |
| Banco de dados | SQLite (desenvolvimento) |
| Autenticação | Laravel Breeze |
| Build de assets | Vite |
| API externa | Spotify Web API |
| CEP | ViaCEP (gratuita) |
| Gráficos | Chart.js |
| Acessibilidade | VLibras |

---

## 3. Instalação e Configuração

### Pré-requisitos
- PHP >= 8.4
- Composer
- Node.js >= 18
- NPM

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/seu-usuario/vinil-de-rua.git
cd vinil-de-rua

# 2. Instale as dependências PHP
composer install

# 3. Instale as dependências JS
npm install

# 4. Configure o ambiente
cp .env.example .env
php artisan key:generate

# 5. Configure o banco de dados no .env
DB_CONNECTION=sqlite

# 6. Rode as migrations
php artisan migrate

# 7. Crie o link simbólico para storage
php artisan storage:link

# 8. Compile os assets
npm run build
# ou para desenvolvimento:
npm run dev

# 9. Inicie o servidor
php artisan serve
```

### Variáveis de ambiente obrigatórias

```env
APP_NAME="Vinil de Rua"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

SPOTIFY_CLIENT_ID=seu_client_id
SPOTIFY_CLIENT_SECRET=seu_client_secret
```

> As credenciais do Spotify são obtidas em [developer.spotify.com](https://developer.spotify.com/dashboard).

### Criando o primeiro administrador

Após criar uma conta pelo formulário de registro, promova o usuário a admin via Tinker:

```bash
php artisan tinker
>>> App\Models\User::where('email', 'seu@email.com')->update(['role' => 'admin']);
```

---

## 4. Estrutura do Banco de Dados

### Diagrama de tabelas

```
users
├── id, name, email, password, role (customer|admin)
├── telefone, cep, endereco, complemento, cidade, estado
└── locale

products
├── id, name, artist, description, price, stock, slug
├── category_id (FK), tag_id (FK)
├── spotify_track_id, status
└── timestamps

categories
├── id, name, banner
└── timestamps

tags
├── id, name
└── timestamps

images
├── id, product_id (FK), path, is_cover
└── timestamps

carts
├── id, user_id (FK)
└── timestamps

cart_items
├── id, cart_id (FK), product_id (FK)
├── units, price (snapshot)
└── timestamps

orders
├── id, user_id (FK), status (pending|approved|cancelled|delivered)
├── payment_method (pix|credit_card), total, tracking_code
└── timestamps

order_items
├── id, order_id (FK), product_id (FK)
├── units, price (snapshot)
└── timestamps

wishlists
├── id, user_id (FK), product_id (FK)
└── timestamps
```

---

## 5. Arquitetura e Estrutura de Pastas

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── CartController.php
│   │   ├── CategoryController.php
│   │   ├── CheckoutController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── ProfileController.php
│   │   ├── SpotifyController.php
│   │   ├── TagController.php
│   │   └── WishlistController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── Cart.php, CartItem.php
│   ├── Category.php, Tag.php
│   ├── Image.php, Product.php
│   ├── Order.php, OrderItem.php
│   ├── User.php, Wishlist.php
└── Services/
    └── SpotifyService.php

resources/views/
├── admin/
│   ├── dashboard.blade.php
│   ├── products/ (index, create, edit)
│   ├── categories/ (index, create, edit)
│   └── tags/ (index, create, edit)
├── auth/ (login, register)
├── cart/ (index, sidebar)
├── category/ (show)
├── checkout/ (index, success)
├── product/ (show)
├── profile/ (index, edit, orders, recently-viewed)
│   └── partials/
├── tag/ (show)
├── wishlist/ (index, sidebar)
└── index.blade.php

public/
├── css/ (estilos por página)
└── js/  (navbar, loading, etc)
```

---

## 6. Rotas

### Públicas (sem autenticação)

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/` | Página inicial (home) |
| GET | `/product` | Catálogo de produtos |
| GET | `/product/{id}` | Página de produto |
| GET | `/categories/{id}` | Produtos por categoria |
| GET | `/tag/show/{tag}` | Produtos por tag |
| GET | `/spotify/token` | Token Spotify para o JS |

### Autenticadas (requer login)

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/cart` | Página do carrinho |
| GET | `/cart/sidebar` | HTML da sidebar do carrinho (AJAX) |
| POST | `/cart/store/{product}` | Adicionar ao carrinho |
| POST | `/cart/decrement/{product}` | Decrementar item |
| POST | `/cart/delete/{product}` | Remover item |
| GET | `/checkout` | Tela de checkout |
| POST | `/checkout` | Finalizar pedido |
| GET | `/orders/success/{order}` | Confirmação de pedido |
| GET | `/profile` | Visualizar perfil |
| GET | `/profile/edit` | Editar perfil |
| GET | `/profile/orders` | Meus pedidos |
| GET | `/profile/recent` | Vistos recentemente |
| GET | `/whishlist` | Lista de favoritos |
| GET | `/whishlist/sidebar` | HTML da sidebar de favoritos (AJAX) |
| POST | `/whishlist/store/{product}` | Favoritar/desfavoritar (toggle) |
| POST | `/whishlist/delete/{product}` | Remover favorito |

### Admin (requer role admin)

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/admin/dashboard` | Dashboard admin |
| GET/POST | `/admin/product/create` | Criar produto |
| GET/PUT | `/admin/product/{id}/edit` | Editar produto |
| DELETE | `/admin/product/{id}` | Deletar produto |
| GET/POST | `/admin/category/create` | Criar categoria |
| PATCH | `/admin/orders/{id}/approve` | Aprovar pedido |
| PATCH | `/admin/orders/{id}/cancel` | Cancelar pedido |

---

## 7. Funcionalidades

### Catálogo e Produtos
- Listagem de produtos com capa, artista, preço e ações
- Página de produto com galeria de imagens, player do Spotify e botão de compra
- Filtragem por categoria e tag
- Produtos em destaque e ofertas na home (controlados por tags)

### Sistema de Desconto
Produtos com a tag **"oferta"** recebem automaticamente **15% de desconto**. O cálculo é feito via accessor no Model `Product`:

```php
// Uso no Blade:
$product->tem_desconto        // boolean
$product->preco_com_desconto  // float com 15% de desconto aplicado
```

### Carrinho
- Sidebar deslizante, sem redirecionamento de página
- Atualização em tempo real via AJAX
- Incremento, decremento e remoção de itens
- Snapshot de preço no momento da adição (protege contra variações de preço)

### Favoritos
- Sidebar deslizante igual ao carrinho
- Toggle (favoritar/desfavoritar) por produto
- Exibe preço com desconto quando aplicável

### Checkout e Pedidos
- Resumo do pedido com dados do usuário
- Formas de pagamento: PIX e Cartão de Crédito
- Após finalizar: estoque decrementado, carrinho limpo, pedido criado com status `pending`

### Histórico Recente
- Últimos 10 produtos visitados (armazenados em sessão)
- Últimas 3 categorias visitadas (armazenadas em sessão)

---

## 8. Integrações Externas

### Spotify Web API
- **Autenticação:** Client Credentials Flow (sem login do usuário)
- **Token:** gerado e cacheado automaticamente por 58 minutos via `SpotifyService`
- **Uso:** busca dinâmica do álbum pelo nome + artista do produto, exibe embed player na tela de compra
- **Rota de token:** `GET /spotify/token` — usada pelo JS do frontend

```javascript
// Fluxo no frontend:
fetch('/spotify/token')           // 1. pega token do Laravel
  → busca álbum na API Spotify    // 2. busca por nome + artista
  → atualiza src do iframe        // 3. exibe o player
```

### ViaCEP
- Preenchimento automático de endereço ao digitar o CEP
- Usado nos formulários de cadastro e edição de perfil
- API pública, sem autenticação necessária

---

## 9. Autenticação e Autorização

- **Autenticação:** gerenciada pelo Laravel Breeze (login, registro, recuperação de senha)
- **Roles disponíveis:** `customer` (padrão) e `admin`
- **Middleware de admin:** `AdminMiddleware` — verifica `auth()->user()->role === 'admin'`
- **Proteção de rotas:** rotas do carrinho e perfil requerem `auth`; rotas admin requerem `auth + admin`

---

## 10. Painel Administrativo

Acessível em `/admin/dashboard` apenas para usuários com `role = admin`.

**Funcionalidades:**
- Cards de resumo: total de produtos, usuários, pedidos pendentes e receita
- Gráfico de pedidos por período (últimos 6 meses) — Chart.js
- Gráfico de produtos mais vendidos (top 5) — Chart.js
- Gráfico de usuários cadastrados por mês — Chart.js
- Tabela de pedidos recentes com ações de aprovar/cancelar
- CRUD completo de produtos, categorias e tags

---

## Licença

Projeto desenvolvido para fins educacionais e de portfólio.

© 2025 Vinil de Rua — Todos os direitos reservados.