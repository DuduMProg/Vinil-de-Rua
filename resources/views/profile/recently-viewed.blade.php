{{-- resources/views/profile/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vistos Recentemente</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/perfil.css')

    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo-Vinil-De-Rua">
            </a>
            <p>VINIL <br>DE RUA</p>
        </div>

        <nav>
            <a href="/#catalogo">Catalogo</a>
            <a href="/tag/show/1">Ofertas</a>
            <a href="#contato">Contato</a>
        </nav>

        <div class="icons">
            <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite" id="btnFavorite" style="cursor:pointer">

            <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart" id="btnCart"
                style="cursor:pointer">

            <button class="areaUsuario" id="btnUsuario">
                <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
            </button>

            <div class="menuLogout" id="menuLogout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="itemMenu">Sair</button>
                </form>
            </div>
        </div>

        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 id="sidebar-title">Carrinho</h2>
                <button id="btnFecharSidebar">✖</button>
            </div>

            <div class="sidebar-content" id="sidebar-content">
                {{-- preenchido via AJAX pelo JS --}}
            </div>

            <div class="btnResumo">
                <a href="/checkout">
                    <button>Resumo da compra</button>
                </a>
            </div>
        </div>

        {{-- Sidebar Favoritos --}}
        <div class="sidebar" id="sidebarFavorite">
            <div class="sidebar-header">
                <h2>Favoritos</h2>
                <button id="btnFecharFavorite">✖</button>
            </div>

            <div class="sidebar-content" id="favorite-content">
                {{-- preenchido via AJAX --}}
            </div>
        </div>
    </header>

    <div class="mobileNav" id="mobileNav">
        <a href="/#catalogo">Catálogo</a>
        <a href="/tag/show/1">Ofertas</a>
        <a href="#contato">Contato</a>
    </div>

    <main>

        <hr>

        <div class="secoesUser">
            <h1>Perfil/ <span>Meu Perfil</span></h1>

            <div class="linksSecao">

                <a href="{{ route('profile.index') }}" class="pageOff">
                    Gerenciar minha Conta
                </a>

                <a href="{{ route('profile.orders') }}" class="pageOff">
                    Meus Pedidos
                </a>

                <a href="{{ route('profile.recent') }}" class="pageOn">
                    Vistos Recentemente
                </a>

            </div>
        </div>

        {{-- substitui a section .vistoRecente --}}
        <section class="vistoRecente">
            <div class="recente2Lados">

                <div class="recenteLado1">
                    <h1>Discos Recentes</h1>

                    <div class="discosRecentes">
                        @forelse($produtos as $p)
                            @php $cover = $p->images->first(); @endphp

                            <a class="cardDisco {{ $p->stock <= 0 ? 'cardDisco--esgotado' : '' }}"
                                href="{{ $p->stock > 0 ? route('product.show', $p->id) : '#' }}">

                                @if($cover)
                                    <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}" class="imgCard">
                                @endif

                                <div class="infoDisco">
                                    <p class="nomeDisco">
                                        {{ $p->name }} - {{ $p->artist }}
                                    </p>

                                    <div class="precoDisco">
                                        @if($p->tem_desconto)
                                            <p class="precoOriginal">
                                                <s>R$ {{ number_format($p->price, 2, ',', '.') }}</s>
                                            </p>
                                            <p class="precoOferta">
                                                R$ {{ number_format($p->preco_com_desconto, 2, ',', '.') }}!
                                            </p>
                                        @else
                                            <p class="precoDisco">
                                                R$ {{ number_format($p->price, 2, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Ícones nos cantos — stopPropagation evita abrir a página do produto ao clicar neles
                                --}}
                                <div class="cardAcoes">

                                    <div class="cart">
                                        <form action="/cart/store/{{ $p->id }}" method="POST"
                                            onclick="event.stopPropagation(); event.preventDefault(); this.submit();">
                                            @csrf
                                            <button type="submit" class="addCarrinho" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                                <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                                            </button>
                                        </form>
                                    </div>

                                    <div class="favorite">
                                        <form action="/whishlist/store/{{ $p->id }}" method="POST"
                                            onclick="event.stopPropagation(); event.preventDefault(); this.submit();">
                                            @csrf
                                            <button type="submit" class="addFav" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                                <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </a>

                        @empty
                            <p>Nenhum disco visto recentemente.</p>
                        @endforelse
                    </div>
                </div>

                <div class="recenteLado2">
                    <h1>Categorias Recentes</h1>

                    <div class="categoriasRecentes">
                        @forelse($categorias as $c)
                            <a href="{{ route('category.show', $c->id) }}" class="cardCategorias">
                                @if($c->banner)
                                    <img src="{{ $c->banner }}" alt="Imagem categoria {{ $c->name }}">
                                @endif
                                <span>
                                    <p>{{ strtoupper($c->name) }}</p>
                                </span>
                            </a>
                        @empty
                            <p>Nenhuma categoria vista recentemente.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </section>

    </main>



    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')
    @vite('resources/js/cards.js')


</body>

</html>