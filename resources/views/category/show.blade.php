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
            <a href="/#catalogo">Cátalogo</a>
            <a href="/tag/show/1">Ofertas</a>
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

    <main>
        <div class="conteiner">

            @if($category->banner)
                <img src="{{ $category->banner }}" alt="Imagem categoria {{ $category->name }}">
            @endif

            <span>
                <p>{{ strtoupper($category->name) }}</p>
            </span>

        </div>
    </main>

    <section class="fundoPrincipal">

        <div class="outrasCategorias">

            <h1>Explorar outras categorias:</h1>

            <div class="categorias">

                @foreach($categories as $c)

                    @if($c->id != $category->id)

                        <a href="{{ route('category.show', $c->id) }}">
                            {{ $c->name }}
                        </a>

                    @endif

                @endforeach

            </div>
        </div>

        <section class="catalogoCategoria">

            @forelse($products as $p)

                @php
                    $cover = $p->images->firstWhere('is_cover', true) ?? $p->images->first();
                @endphp

                <div class="cardDisco">

                    @if($cover)
                        <img 
                            src="{{ $cover->path }}" 
                            alt="Capa de {{ $p->name }}"
                            class="imgCard"
                        >
                    @endif

                    <div class="infoDisco">

                        <p class="nomeDisco">
                            {{ $p->name }} - {{ $p->artist }}
                        </p>

                        <p class="precoDisco">
                            R$ {{ number_format($p->price, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="preçoEFavDisco">

                        <button 
                            class="btnComprarAgora"
                            onclick="window.location.href='{{ route('product.show', $p->id) }}'"
                            {{ $p->stock <= 0 ? 'disabled' : '' }}
                        >
                            {{ $p->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                        </button>

                        <div class="cart">

                            <form action="/cart/store/{{ $p->id }}" method="POST">
                                @csrf

                                <button 
                                    type="submit"
                                    class="addCarrinho"
                                    {{ $p->stock <= 0 ? 'disabled' : '' }}
                                >
                                    <img 
                                        src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png"
                                        alt="carrinho"
                                    >
                                </button>

                            </form>

                        </div>

                        <div class="favorite">

                            <a href="/favorite">
                                <img 
                                    src="https://i.ibb.co/5mHR0sq/favorite-Black.png"
                                    alt="favorito"
                                >
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <p>Nenhum produto nessa categoria.</p>

            @endforelse

        </section>

        <footer id="contato">

            <div class="footerContainer">

                <div class="footerLogo">

                    <img 
                        src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
                        alt="Vinil de Rua"
                        class="logo"
                    >

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

                        <img 
                            style="cursor: pointer;"
                            onclick="window.open('https://wa.me/5511945859221', '_blank')"
                            src="https://i.ibb.co/d0pJB3H5/zapLogo.png"
                            alt="WhatsApp"
                        >

                        <img 
                            style="cursor: pointer;"
                            onclick="window.open('https://www.instagram.com/', '_blank')"
                            src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png"
                            alt="Instagram"
                        >

                        <img 
                            style="cursor: pointer;"
                            onclick="window.open('https://br.pinterest.com/', '_blank')"
                            src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png"
                            alt="Pinterest"
                        >

                        <img 
                            style="cursor: pointer;"
                            onclick="window.open('https://www.facebook.com/', '_blank')"
                            src="https://i.ibb.co/SXZ6bhxx/faceLogo.png"
                            alt="Facebook"
                        >

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
                <p>Copyright © 2025 Vinil de Rua</p>
            </div>

        </footer>

    </section>

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/loading.js') }}"></script>
    <script src="{{ asset('js/carrinho.js') }}"></script>
    <script src="{{ asset('js/conexao.js') }}"></script>
    <script src="{{ asset('js/telaDeCompra.js') }}"></script>

</body>