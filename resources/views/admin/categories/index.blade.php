
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - ADM</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    @vite('resources/css/styleAdm.css')
</head>
<body>

<div class="painelAdmin">

    <!-- MENU LATERAL -->
    <aside class="menuLateral">
        <div class="areaLogo">
            <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
            <h1>Vinil de Rua</h1>
        </div>

        <nav class="menuPrincipal">
            <button class="itemMenu" onclick="window.location.href='/admin/dashboard'">Dashboard</button>
            <button class="itemMenu" onclick="window.location.href='/admin/product/create'">Adicionar Produto</button>
            <button class="itemMenu" onclick="window.location.href='/admin/product'">Todos os produtos</button>
            <button class="itemMenu" onclick="window.location.href='/admin/orders'">Pedidos</button>
        </nav>

        <div class="menuCategorias">
            <h1>Categorias</h1>
            <ul>
                <li>
                    <a href="/admin/category" class="linkMenuCat ativo">Ver todas</a>
                </li>
                <li>
                    <a href="/admin/category/create" class="linkMenuCat">+ Nova categoria</a>
                </li>
                @foreach($categories as $c)
                    <li>
                        <a href="/admin/category/{{ $c->id }}/edit" class="linkMenuCat">
                            {{ $c->name }}
                            <span>{{ $c->products_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="menuTagsLink">
                <h1>Tags</h1>
                <ul>
                    <li><a href="/admin/tag" class="linkMenuCat">Ver todas</a></li>
                    <li><a href="/admin/tag/create" class="linkMenuCat">+ Nova tag</a></li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="conteudoPrincipal">

        <header class="menuSuperior">
            <div class="campoBusca">
                <input type="text" placeholder="Buscar categoria...">
                <div class="btnBusca"><button>Buscar</button></div>
            </div>
            <div class="areaUsuario">
                <i class="icon-user" id="btnUsuario">
                    <img src="https://i.ibb.co/v6qZmTGv/perfil-Icon.png" alt="">
                </i>
                <div class="menuLogout" id="menuLogout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="itemMenu">Sair</button>
                    </form>
                </div>
            </div>
        </header>

        <section class="secaoProdutos">

            <div class="tituloEAcao">
                <h1 class="tituloSecao">Categorias</h1>
            </div>

            @if(session('success'))
                <p class="mensagemSucesso">{{ session('success') }}</p>
            @endif

            <div class="adminProdutosGrid">
                @forelse($categories as $c)
                    <div class="adminCard">

                        <div class="adminCardCapa">
                            @if($c->banner)
                                <img src="{{ $c->banner }}" alt="Banner {{ $c->name }}">
                            @else
                                <div class="semCapa">Sem banner</div>
                            @endif
                        </div>

                        <div class="adminCardInfo">
                            <div class="adminCardTitulo">
                                <p class="adminCardNome">{{ $c->name }}</p>
                            </div>
                            <div class="adminCardDetalhes">
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">Produtos</span>
                                    <span class="detalheValor">{{ $c->products_count }}</span>
                                </div>
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">ID</span>
                                    <span class="detalheValor">#{{ $c->id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="adminCardAcoes">
                            <a href="/admin/category/{{ $c->id }}/edit" class="btnAdminEditar">Editar</a>
                            <form action="/admin/category/{{ $c->id }}" method="POST"
                                  onsubmit="return confirm('Deletar {{ $c->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btnAdminDeletar">Deletar</button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="semProdutos">Nenhuma categoria cadastrada.</p>
                @endforelse
            </div>

        </section>
    </main>
</div>

@vite('resources/js/loading.js')
@vite('resources/js/admin.js')
</body>
</html>

