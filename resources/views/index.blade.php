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
                                <div class="precoDisco">

                                    <p class="precoOferta">
                                        R$ {{ number_format($o->preco_com_desconto, 2, ',', '.') }}!
                                    </p>

                                </div>
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

                        {{-- Ícones nos cantos — stopPropagation evita abrir a página do produto ao clicar neles --}}
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

                {{-- Coluna 1: Logo + tagline + redes --}}
                <div class="footerLogo">
                    <div class="footerLogoRow">
                        <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua">
                        <h1>VINIL <br>DE RUA</h1>
                    </div>
                    <p class="footerTagline">Discos para quem vive a música.<br>Curadoria independente desde 2025.</p>
                    <div class="socialLogo">
                        <img onclick="window.open('https://wa.me/5511945859221','_blank')"
                            src="https://i.ibb.co/d0pJB3H5/zapLogo.png" alt="WhatsApp">
                        <img onclick="window.open('https://www.instagram.com/','_blank')"
                            src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png" alt="Instagram">
                        <img onclick="window.open('https://br.pinterest.com/','_blank')"
                            src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png" alt="Pinterest">
                        <img onclick="window.open('https://www.facebook.com/','_blank')"
                            src="https://i.ibb.co/SXZ6bhxx/faceLogo.png" alt="Facebook">
                    </div>
                </div>

                {{-- Coluna 2: Navegação --}}
                <div class="footerCol">
                    <h3>Navegação</h3>
                    <ul>
                        <li><a href="/product">Catálogo</a></li>
                        <li><a href="/tag/show/1">Ofertas</a></li>
                        <li><a href="/#catalogo">Categorias</a></li>
                        @auth
                            <li><a href="{{ route('profile.index') }}">Minha conta</a></li>
                            <li><a href="{{ route('profile.orders') }}">Meus pedidos</a></li>
                        @else
                            <li><a href="/login">Entrar</a></li>
                            <li><a href="/register">Criar conta</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Coluna 3: Informações --}}
                <div class="footerCol">
                    <h3>Informações</h3>
                    <ul>
                        <li><a href="#">Política de privacidade</a></li>
                        <li><a href="#">Trocas e devoluções</a></li>
                        <li><a href="#">Prazo de entrega</a></li>
                        <li><a href="#">Termos de uso</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                {{-- Coluna 4: Contato + Pagamento --}}
                <div class="footerCol">
                    <h3>Contato</h3>
                    <p>vinil.derua01@gmail.com</p>
                    <p>(11) 94585-9221</p>
                    <p class="footerHorario">Seg–Sex, 9h às 21h<br>Sáb, 10h às 18h</p>

                    <div class="footerPagamentos">
                        <h3>Pagamento seguro</h3>
                        <div class="formasPagamentoImg">
                            <img src="https://i.ibb.co/PGTbDWv8/applePay.png" alt="Apple Pay">
                            <img src="https://i.ibb.co/j9xwJZxb/google-Pay.png" alt="Google Pay">
                            <img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="Mastercard">
                            <img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="PIX">
                            <img src="https://i.ibb.co/RGHkXJks/visaPay.png" alt="Visa">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Rodapé inferior --}}
            <div class="copyrightVdR">
                <p>© 2026 Vinil de Rua. Todos os direitos reservados.</p>
                <div class="footerBottomLinks">
                    <a href="#">Privacidade</a>
                    <a href="#">Termos</a>
                    <a href="#">Cookies</a>
                </div>
                <span class="stripeBadge">Pagamentos processados com segurança por Stripe</span>
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
    @vite('resources/js/index.js')
    @vite('resources/js/cards.js')

</body>


</html>