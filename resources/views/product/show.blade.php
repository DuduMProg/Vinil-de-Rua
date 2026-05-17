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
            <a href="/tag/show/oferta">Ofertas</a>
            <a href="#contato">Contato</a>
        </nav>

        <div class="icons">
            <a href="/favorite">
                <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite">
            </a>
            <a href="/cart">
                <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart">
            </a>
            <a href="/profile">
                <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
            </a>
        </div>
    </header>


    <section class="telaCompra">

        @php
            $cover = $product->images->first();
            $secundarias = $product->images->skip(1);
        @endphp

        {{-- Coluna esquerda: imagens --}}
        <section class="detalhesProduto">
            <div class="nomeProduto">
                <h1>{{ $product->name }} - {{ $product->artist }}</h1>
            </div>
            <div class="imgProduto">

                {{-- Imagem principal (capa) --}}
                @if($cover)
                    <img src="{{ $cover->path }}" alt="Capa de {{ $product->name }}" id="imgPrincipal">
                @endif

                {{-- Miniaturas: apenas imagens secundárias (is_cover = false) --}}
                @if($secundarias->count() > 0)
                    <div class="imgProdutoMini">
                        @foreach($secundarias as $img)
                            <img src="{{ $img->path }}" alt="Imagem de {{ $product->name }}" class="cadaImgMini"
                                style="cursor:pointer">
                        @endforeach
                    </div>
                @endif

            </div>



            <div class="descricaoProduto">
                <p>{{ $product->description }}</p>
            </div>

        </section>

        {{-- Coluna direita: infos + Spotify + compra --}}
        <section class="infosProduto">


            {{-- Player Spotify dinâmico --}}
            <div class="tracklist">
                <iframe id="spotifyEmbed" src="" width="400px" height="352" frameborder="0"
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"
                    style="border-radius:12px; display:none">
                </iframe>
                <p id="spotifyErro" class="spotifyErro" style="display:none">
                    Álbum não encontrado no Spotify :(
                </p>
            </div>

            {{-- Preço e botão de compra --}}
            <div class="finalizarCompra">
                <p>R$ {{ number_format($product->price, 2, ',', '.') }}</p>

                <form action="/cart/store/{{ $product->id }}" method="POST">
                    @csrf
                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                    </button>
                </form>
            </div>

        </section>

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

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')
    @vite('resources/js/telaDeCompra.js')

</body>

</html>