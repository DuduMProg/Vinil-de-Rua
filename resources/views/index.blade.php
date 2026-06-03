<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinil de Rua - Home</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/index.css')
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
    <a href="/favorite">
        <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite">
    </a>

    <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart" id="btnCart" style="cursor:pointer">

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
    </header>

    <main>
        <section class="conteiner">
            <div class="textConteiner">
                <h1><span>Vinil de Rua</span> o site feito para quem ama musica de verdade</h1>
                <p>Confira agora nosso catalogo, com discos ate 70% de desconto.</p>
            </div>
            <div class="imageHero">
                <div class="banner">
                  <img src="https://i.ibb.co/tTHjxkRD/disco-Vinil-De-Rua.png" class="shape">

                  <!-- disco girando -->
                  <img src="https://i.ibb.co/r2nBVtd4/vinil-Rodando.png" class="vinyl">

                  <!-- artista -->
                  <img src="https://i.ibb.co/whWdbjdM/img-Sabota-Hero.png" class="artist">

                </div>
            </div>
        </section>
    </main>

    <section class="fundoPrincipal">

        <section class="offECatalogo" id="catalogo">

            {{-- Card de Ofertas --}}
            <div class="cardOff" id="cardOff">
                <button class="closeCard" id="closeCard">x</button>

                <div class="linkEImg">
                    <div class="offEimg">
                        <h1>COM 15% OFF, LIMITADO!</h1>
                        <a href="/tag/show/1" class="offDisco">VEJA MAIS AQUI</a>
                    </div>
                    <img src="https://i.ibb.co/yckTbjhV/paleta.png" alt="">
                </div>

                <div class="listaDiscos">
                    @forelse($ofertas as $o)
                        @php $cover = $o->images->first() @endphp
                        <div class="cardDiscoOff">
                            @if($cover)
                                <img src="{{ $cover->path }}" alt="Capa {{ $o->name }}" class="imgCard">
                            @endif
                            <div class="infoDisco">
                                <p class="nomeDisco">{{ $o->name }} - {{ $o->artist }}</p>
                                <p class="offDisco">R$ {{ number_format($o->price, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p>Nenhuma oferta no momento.</p>
                    @endforelse
                </div>
            </div>

            {{-- Catalogo de Destaques --}}
            <div class="catalogoIndex">
                @forelse($destaques as $p)
                    @php $cover = $p->images->first() @endphp
                    <div class="cardDisco">

                        @if($cover)
                            <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}" class="imgCard">
                        @endif

                        <div class="infoDisco">
                            <p class="nomeDisco">{{ $p->name }} - {{ $p->artist }}</p>
                            <div class="precoDisco">
                                @if($p->tem_desconto)
                                    <p class="precoOriginal">
                                        <s>R$ {{ number_format($p->price, 2, ',', '.') }}</s>
                                    </p>
                                    <p class="precoOferta">
                                        R$ {{ number_format($p->preco_com_desconto, 2, ',', '.') }} !
                                    </p>
                                @else
                                    <p class="precoDisco">
                                        R$ {{ number_format($p->price, 2, ',', '.') }}
                                    </p>
                                @endif
                            </div>          
                        </div>

                        <div class="precoEFavDisco">
                            <button class="btnComprarAgora"
                                onclick="window.location.href='{{ route('product.show', $p->id) }}'"
                                {{ $p->stock <= 0 ? 'disabled' : '' }}>
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
                                <form action="/favorite/store/{{ $p->id }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; cursor:pointer">
                                        <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <p>Nenhum produto em destaque no momento.</p>
                @endforelse
            </div>

        </section>



        {{-- Explorar Categorias --}}
        <section class="explorarCategorias">
            <h1>Explorar por categorias</h1>
            <div class="categorias">
                @forelse($categories as $c)
                    <a class="cardCategorias" href="{{ route('category.show', $c->id) }}">
                        @if($c->banner)
                            <img src="{{ $c->banner }}" alt="Imagem categoria {{ $c->name }}">
                        @endif
                        <span>
                            <p>{{ strtoupper($c->name) }}</p>
                        </span>
                    </a>
                @empty
                    <p>Nenhuma categoria cadastrada.</p>
                @endforelse
            </div>
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
                        <img style="cursor:pointer" onclick="window.open('https://wa.me/5511945859221', '_blank')"
                            src="https://i.ibb.co/d0pJB3H5/zapLogo.png" alt="WhatsApp">
                        <img style="cursor:pointer" onclick="window.open('https://www.instagram.com/', '_blank')"
                            src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png" alt="Instagram">
                        <img style="cursor:pointer" onclick="window.open('https://br.pinterest.com/', '_blank')"
                            src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png" alt="Pinterest">
                        <img style="cursor:pointer" onclick="window.open('https://www.facebook.com/', '_blank')"
                            src="https://i.ibb.co/SXZ6bhxx/faceLogo.png" alt="Facebook">
                    </div>
                </div>

                <div class="formasPagamento">
                    <h1>Formas de pagamento</h1>
                    <hr>
                    <div class="formasPagamentoImg">
                        <img src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png" alt="fiadoPay">
                        <img src="https://i.ibb.co/PGTbDWv8/applePay.png" alt="applePay">
                        <img src="https://i.ibb.co/j9xwJZxb/google-Pay.png" alt="google-Pay">
                        <img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="mastercard-Pay">
                        <img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay">
                        <img src="https://i.ibb.co/RGHkXJks/visaPay.png" alt="visaPay">
                    </div>
                </div>

            </div>

            <div class="copyrightVdR">
                <p>Copyright 2025 Vinil de Rua</p>
            </div>
        </footer>

    </section>

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

</body>


</html>