<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    @vite('resources/css/pageOff.css')
    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">


</head>

<body>

    {{-- resources/views/tag/show.blade.php --}}

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

        <div class="icons">
            <a href="/favorite">
                <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite">
            </a>

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
            <div class="menuLogout">
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
    </header>


    <h1>{{ $tag->name }}</h1>

    <p>{{ $products->count() }} disco(s) encontrado(s)</p>

    <section class="fundoPrincipal" #catalogoOff>

        <div class="bannerBlackFriday">
            <div class="anuncioBlackFriday">
                <h1>DESCONTOS EM DISCOS COM 15% OFF!!</h1>
            </div>

        </div>

        <section class="filtroECat">
            <aside class="sidebarFiltro" id="sidebarFiltro">

                <div class="filtroTitulo">
                    <img src="https://i.ibb.co/r2nBVtd4/vinil-Rodando.png" class="vinyl">
                    <h2>Filtros</h2>
                </div>

                <div class="grupoFiltro">

                    <h3>Preço</h3>

                    <label>
                        <input type="checkbox" class="filtroPreco" value="100">
                        Até R$100
                    </label>

                    <label>
                        <input type="checkbox" class="filtroPreco" value="200">
                        R$100 - R$200
                    </label>

                    <label>
                        <input type="checkbox" class="filtroPreco" value="300">
                        R$200 - R$300
                    </label>

                    <label>
                        <input type="checkbox" class="filtroPreco" value="400">
                        R$300 - R$400
                    </label>

                </div>

                <div class="grupoFiltro">

                    <h3>Categorias</h3>
                    @foreach($categories as $category)
                        <label>
                            <input type="checkbox" class="filtroCategoria" value="{{ strtolower($category->name) }}">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach

                </div>
                <div class="btnsfiltro">

                    <button class="btnLimpar">
                        Limpar filtros
                    </button>
                    <button class="btnFiltrar">
                        Aplicar filtros
                    </button>
                </div>

            </aside>

            <section class="catalogoOff">
                @forelse($products as $p)

                    @php
                        $cover = $p->images->firstWhere('is_cover', true)
                            ?? $p->images->first();

                        $oldPrice = $p->price;
                        $discountPrice = $p->price * 0.6;
                    @endphp

                    <div class="cardDisco" preco="{{ $discountPrice }}" preco="{{ $discountPrice }}" categoria="{{ strtolower($p->category->name) }}">

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

                        <div class="preçoEFavDisco">

                            <button class="btnComprarAgora"
                                onclick="window.location.href='{{ route('product.show', $p->id) }}'">
                                {{ $p->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                            </button>

                            <div class="cart">

                                <form action="/cart/store/{{ $p->id }}" method="POST">

                                    @csrf

                                    <button type="submit" class="addCarrinho" {{ $p->stock <= 0 ? 'disabled' : '' }}>

                                        <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">

                                    </button>

                                </form>

                            </div>

                            <div class="favorite">

                                <a href="/src/assets/pages/favorito.html">

                                    <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhum produto nessa categoria.</p>

                @endforelse
            </section>

        </section>
        <footer id="contato">
            <div class="footerContainer">
                <div class="footerLogo">
                    <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">
                    <h1>VINIL <br>DE RUA</h1>
                </div>
                <div class="socialConteiner">
                    <div class="footerCtt">
                        <h1>Contato</h1>
                        <hr>
                        <p>contato@vinilderua.com.br</p>
                        <p>(11) 11 4002-8922</p>
                    </div>
                    <p class="social">Nos siga:</p>
                    <div class="socialLogo">
                        <img style="cursor: pointer;" onclick="window.open('https://wa.me/5511945859221', '_blank')"
                            src="https://i.ibb.co/d0pJB3H5/zapLogo.png" alt="WhatsApp">
                        <img style="cursor: pointer;"
                            onclick="window.open('https://www.instagram.com/duudjs_/', '_blank')"
                            src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png" alt="Instagram">
                        <img style="cursor: pointer;" onclick="window.open('https://br.pinterest.com/', '_blank')"
                            src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png" alt="Pinterest">
                        <img style="cursor: pointer;" onclick="window.open('https://www.facebook.com/', '_blank')"
                            src="https://i.ibb.co/SXZ6bhxx/faceLogo.png" alt="Facebook">
                    </div>
                </div>
                <div class="formasPagamento">
                    <h1>Formas de pagamento</h1>
                    <hr>
                    <div class="formasPagamentoImg">
                        <a href="https://ibb.co/5gLxyp3k"><img src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png"
                                alt="fiadoPay"></a>
                        <a href=""><img src="https://i.ibb.co/PGTbDWv8/applePay.png" alt="applePay"></a>
                        <a href=""><img src="https://i.ibb.co/j9xwJZxb/google-Pay.png" alt="google-Pay"></a>
                        <a href=""><img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="mastercard-Pay"></a>
                        <a href=""><img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay" </a>
                            <a href=""><img src="https://i.ibb.co/RGHkXJks/visaPay.png" alt="visaPay"></a>
                    </div>
                </div>
            </div>
            <div class="copyrightVdR">
                <p>Copyright © 2025 Vinil de Rua </p>
            </div>
        </footer>
    </section>

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')
    @vite('resources/js/telaDeCompra.js')
    @vite('resources/js/filtro.js')
</body>

</html>