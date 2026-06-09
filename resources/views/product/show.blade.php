<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - {{ $product->name }} - {{ $product->artist }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <!-- SEPARAÇÃO -->
    @vite('resources/css/telaDeCompra.css')
    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">


</head>



<body class="fundoPrincipal">

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
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

        <div class="mobileMenuBtn" id="btnMenu">
            ☰
        </div>

        <div class="icons">
            <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite" id="btnFavorite" style="cursor:pointer">

            <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart" id="btnCart"
                style="cursor:pointer">

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="/admin/dashboard">
                        <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                    </a>
                @else
                    <a href="/profile">
                        <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                    </a>
                @endif
            @else
                <a href="/login">
                    <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                </a>
            @endauth
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


    <section class="telaCompra">

        @php
            $cover = $product->images->first();
            $secundarias = $product->images->skip(1);
        @endphp

        {{-- Coluna esquerda: imagens --}}
        <div class="detalhesProduto">
            <div class="nomeProduto">
                <h1>{{ $product->name }} - {{ $product->artist }}</h1>
            </div>

            <div class="imgProduto">

                {{-- Imagem principal (capa) — JS abre o lightbox no índice 0 --}}
                @if($cover)
                    <img src="{{ $cover->path }}" alt="Capa de {{ $product->name }}" class="imgPrincipal">
                @endif

                {{-- Miniaturas secundárias — JS as pega como índices 1, 2, 3... --}}
                @if($secundarias->count() > 0)
                    <div class="imgProdutoMini">
                        @foreach($secundarias as $img)
                            <img src="{{ $img->path }}" alt="Imagem de {{ $product->name }}" class="cadaImgMini">
                        @endforeach
                    </div>
                @endif

            </div>

            <div class="descricaoProduto">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="">
                <p>{{ $product->description }}</p>
            </div>
        </div>

        {{-- ↓ LIGHTBOX — coloca aqui, logo antes do
</body> da view ↓ --}}
<div class="lb-fundo" id="lb">
    <div class="lb-topo">
        <span class="lb-contador" id="lb-contador">1 / 1</span>
        <button class="lb-fechar" id="lb-fechar">✕</button>
    </div>
    <div class="lb-centro">
        <button class="lb-nav lb-prev" id="lb-prev">&#8592;</button>
        <div class="lb-img-wrap" id="lb-wrap">
            <img class="lb-img" id="lb-img" src="" alt="">
        </div>
        <button class="lb-nav lb-next" id="lb-next">&#8594;</button>
    </div>
    <div class="lb-miniaturas" id="lb-minis"></div>
</div>

{{-- Coluna direita: infos + Spotify + compra --}}
<div class="infosProduto">

    {{-- Player Spotify dinâmico --}}
    <div class="tracklist">
        <iframe id="spotifyEmbed" src="" frameborder="0"
            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"
            style="border-radius:12px; display:none">
        </iframe>
        <p id="spotifyErro" class="spotifyErro" style="display:none">
            Álbum não encontrado no Spotify :(
        </p>
    </div>

    {{-- Preço e botão de compra --}}
    <div class="finalizarCompra">

        @if($product->tem_desconto)
            <p><s>R$ {{ number_format($product->price, 2, ',', '.') }}</s></p>
            <p class="precoOferta">R$ {{ number_format($product->preco_com_desconto, 2, ',', '.') }}</p>
        @else
            <p class="precoOriginal">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
        @endif

        <form action="/cart/store/{{ $product->id }}" method="POST">
            @csrf
            <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                {{ $product->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
            </button>
        </form>

    </div>

</div>

</section>

{{-- Dados do produto para o JS ler — sem hardcode --}}
<div id="spotifyData" data-album="{{ $product->name }}" data-artist="{{ $product->artist }}" style="display:none">
</div>

<footer id="contato">
    <div class="footerLogo">
        <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">
        <h1>VINIL <br>DE RUA</h1>
    </div>

    <div class="avisosFooter">
        <p>Duvidas? (11) 4002-8922 (SP)</p>
        <p>Seg a Sex, 9h às 21h Sáb 10h às 18h</p>

    </div>
    <div class="termos">
        <a href="">Termos e Condições</a>
    </div>

</footer>

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
@vite('resources/js/telaDeCompra.js')

</body>

</html>