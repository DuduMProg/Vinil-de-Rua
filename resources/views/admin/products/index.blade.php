<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Page</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    @vite('resources/css/styleAdm.css')

</head>

<body>


    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

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
                    <a href="/admin/category" class="linkMenuCat">Ver todas</a>
                </li>
                <li>
                    <a href="/admin/category/create" class="linkMenuCat">+ Nova categoria</a>
                </li>
            </ul>

            <div class="menuTagsLink">
                <h1>Tags</h1>
                <ul>
                    <li><a href="/admin/tag" class="linkMenuCat">Ver todas</a></li>
                    <li><a href="/admin/tag/create" class="linkMenuCat ativo">+ Nova tag</a></li>
                </ul>
            </div>
        </div>
    </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudoPrincipal">

            <!-- MENU SUPERIOR -->
            <header class="menuSuperior">

                <div class="adminBuscaFiltros">

                    {{-- Campo de busca --}}
                    <div class="campoBusca">
                        <input type="text" id="inputBusca" placeholder="Buscar por nome ou artista...">
                        <div class="btnBusca">
                            <button onclick="filtrar()">Buscar</button>
                        </div>
                    </div>

                    {{-- Filtros rápidos --}}
                    <div class="filtrosRapidos">

                        <button class="btnFiltro ativo" data-filtro="todos">
                            Todos
                        </button>

                        <button class="btnFiltro" data-filtro="oferta">
                            Oferta
                        </button>

                        <button class="btnFiltro" data-filtro="index">
                            Index
                        </button>

                        <button class="btnFiltro" data-filtro="destaque">
                            Destaque
                        </button>

                        <button class="btnFiltro" data-filtro="estoque-baixo">
                            Estoque baixo
                        </button>

                        <button class="btnFiltro" data-filtro="sem-tag">
                            Sem tag
                        </button>

                        <button class="btnFiltro" data-filtro="sem-imagem">
                            Sem imagem
                        </button>

                        <p class="contadorResultados" id="contadorResultados"></p>
                    </div>

                    {{-- Contador de resultados --}}

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



            <div class="adminProdutosGrid">

                @forelse($products as $p)
                    @php
                        $cover = $p->images->firstWhere('is_cover', true) ?? $p->images->first();
                    @endphp

                    <div class="adminCard" data-nome="{{ strtolower($p->name) }}"
                        data-artista="{{ strtolower($p->artist) }}" data-tag="{{ $p->tag->name ?? '' }}"
                        data-estoque="{{ $p->stock }}" data-imagens="{{ $p->images_count }}">

                        {{-- Capa do álbum --}}
                        <div class="adminCardCapa">
                            @if($cover)
                                <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}">
                            @else
                                <div class="semCapa">Sem capa</div>
                            @endif

                            {{-- Badge de tag --}}
                            @if($p->tag)
                                <span class="adminBadgeTag badge-{{ $p->tag->name }}">
                                    {{ strtoupper($p->tag->name) }}
                                </span>
                            @endif
                        </div>

                        {{-- Informações --}}
                        <div class="adminCardInfo">

                            <div class="adminCardTitulo">
                                <p class="adminCardNome">{{ $p->name }}</p>
                                <p class="adminCardArtista">{{ $p->artist }}</p>
                            </div>

                            <div class="adminCardDetalhes">
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">Categoria</span>
                                    <span class="detalheValor">{{ $p->category->name ?? '—' }}</span>
                                </div>
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">Estoque</span>
                                    <span class="detalheValor {{ $p->stock <= 5 ? 'estoqueAlerta' : '' }}">
                                        {{ $p->stock }} un.
                                    </span>
                                </div>
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">Preço</span>
                                    <span class="detalheValor">R$ {{ number_format($p->price, 2, ',', '.') }}</span>
                                </div>
                                <div class="adminCardDetalhe">
                                    <span class="detalheLabel">Imagens</span>
                                    <span class="detalheValor">{{ $p->images_count }}</span>
                                </div>
                            </div>

                        </div>

                        {{-- Ações --}}
                        <div class="adminCardAcoes">
                            <a href="/admin/product/{{ $p->id }}/edit" class="btnAdminEditar">
                                Editar
                            </a>

                            <form action="/admin/product/{{ $p->id }}" method="POST"
                                onsubmit="return confirm('Deletar {{ $p->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btnAdminDeletar">
                                    Deletar
                                </button>
                            </form>
                        </div>

                    </div>

                @empty
                    <p class="semProdutos">Nenhum produto cadastrado ainda.</p>
                @endforelse

            </div>

        </main>

    </div>

    @vite('resources/js/admin.js')

</body>

</html>