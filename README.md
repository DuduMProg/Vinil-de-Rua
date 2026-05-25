````md id="4l3h6x"
# Vinil de Rua

<p align="center">
  <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" width="180" alt="Logo Vinil de Rua">
</p>

<p align="center">
  Plataforma web de e-commerce para venda de discos de vinil, desenvolvida como projeto acadêmico utilizando Laravel, Blade, JavaScript e SQLite.
</p>

---

## Sobre o projeto

O Vinil de Rua é uma plataforma de catálogo e venda de discos de vinil inspirada na cultura urbana, hip-hop e colecionismo musical.

O sistema foi desenvolvido com foco em:

- experiência visual moderna;
- organização de catálogo por categorias;
- gerenciamento administrativo;
- carrinho de compras dinâmico;
- arquitetura MVC utilizando Laravel.

O projeto está sendo desenvolvido como atividade acadêmica da faculdade, aplicando conceitos de:

- desenvolvimento full stack;
- banco de dados relacionais;
- arquitetura MVC;
- integração front-end + back-end;
- responsividade;
- manipulação de rotas e controllers;
- CRUD completo.

---

# Tecnologias utilizadas

## Back-end
- PHP
- Laravel 13
- Blade Engine
- SQLite

## Front-end
- HTML5
- CSS3
- JavaScript Vanilla

## Ferramentas
- Git & GitHub
- DBeaver
- Figma
- VS Code

---

# Layout do projeto

## Página inicial
- catálogo de produtos;
- destaques;
- categorias musicais;
- visual inspirado em lojas de vinil urbanas.

## Carrinho lateral (Sidebar Cart)
- abertura dinâmica com JavaScript;
- atualização de itens;
- incremento/decremento de quantidade;
- resumo da compra.

## Sistema de categorias

Categorias dinâmicas vindas do banco:

- Grime
- Drill
- R&B
- Boombap
- 90's / Y2K

Cada categoria possui:
- banner próprio;
- produtos filtrados;
- visual personalizado.

## Painel Administrativo

Área responsável pelo gerenciamento do sistema:

- listar produtos;
- cadastrar produtos;
- editar produtos;
- deletar produtos;
- controle de estoque;
- categorias e tags;
- upload de imagens por URL.

---

# Estrutura do projeto

```bash
app/
resources/
 ├── views/
 │    ├── product/
 │    ├── category/
 │    ├── cart/
 │    └── layouts/
public/
database/
routes/
````

---

# Funcionalidades

## Implementadas

* CRUD de produtos
* Sistema de categorias
* Sistema de tags
* Carrinho de compras
* Sidebar dinâmica
* Sistema de estoque
* Página administrativa
* Integração com banco SQLite
* Relacionamentos Eloquent
* Renderização dinâmica com Blade
* Layout responsivo

## Em desenvolvimento

* Sistema de favoritos
* Dashboard administrativa
* Sistema de autenticação
* Checkout completo
* Upload local de imagens
* Busca dinâmica

---

# Modelagem do banco

## Relacionamentos

### Product

* pertence a uma Category
* pertence a uma Tag
* possui várias Images

### Category

* possui vários Products

### Tag

* possui vários Products

---

# Como rodar o projeto

## 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/vinil-de-rua.git
```

---

## 2. Acesse a pasta

```bash
cd vinil-de-rua
```

---

## 3. Instale as dependências

```bash
composer install
```

---

## 4. Configure o `.env`

```env
DB_CONNECTION=sqlite
```

---

## 5. Gere a chave do projeto

```bash
php artisan key:generate
```

---

## 6. Rode as migrations

```bash
php artisan migrate
```

---

## 7. Inicie o servidor

```bash
php artisan serve
```

---

# Organização visual

O projeto utiliza:

* identidade visual inspirada em streetwear;
* tipografia urbana;
* componentes reutilizáveis;
* sidebar administrativa;
* cards dinâmicos;
* grids responsivos.

---

# Aprendizados

Durante o desenvolvimento deste projeto foram aplicados conhecimentos como:

* Laravel MVC;
* Eloquent ORM;
* Blade Components;
* manipulação de rotas;
* integração entre front-end e back-end;
* estruturação de banco de dados;
* responsividade;
* componentização visual;
* experiência do usuário (UI/UX).

---

# Desenvolvedor

### Eduardo José
### Júlia Eduarda

Estudante de Sistemas para Internet — Senac
Focado em desenvolvimento full stack, redes e segurança.

---

# Licença

Este projeto foi desenvolvido para fins acadêmicos e educacionais.

---

<p align="center">
  Feito com Laravel.
</p>
```
