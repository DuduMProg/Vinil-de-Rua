<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$category->name}}</title>
    <link rel="stylesheet" href="{{ asset('/css/category.css') }}">
    
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="shortcut icon" type="imagex/png" href="/src/assets/images/logoVinilDeRua.svg">
</head>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        scroll-behavior: smooth;
    }

    :root {
        /* fontes */
        --fontePrimaria: 'Caesar Dressing', cursive;
        --fonteSecundaria: 'Anton', sans-serif;
        --fonteTerciaria: "Young Serif", serif;
        /* Cores */
        --gradienteVertical1: linear-gradient(180deg, rgba(191, 191, 191, 1) 0%, rgba(81, 81, 81, 1) 100%);
        --gradienteVertical2: linear-gradient(180deg, rgba(81, 81, 81, 1) 0%, rgba(191, 191, 191, 1) 100%);
        --gradienteCardDiscos: linear-gradient(-41deg, rgba(159, 159, 159, 1) 0%, rgba(255, 255, 255, 1) 100%);
        /* drop shadow discos */
        --dropShadowDiscos: box-shadow: 0px 0px 6px 6px rgba(0, 0, 0, 0.404);
    }

    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }


    header {
        width: 100%;
        height: 110px;
        display: flex;
        align-items: center;
        padding: 0 25px;
        justify-content: space-between;
        background-color: transparent;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    nav {
        display: flex;
        gap: 78px;
    }

    nav a {
        text-decoration: none;
        color: #FFFFFF;
        font-family: "Caesar Dressing", system-ui;
        font-size: 32px;
        transition: color 0.8 ease-in-out;
    }

    header img {
        width: 87px;
        height: 87px;
    }

    .logoHeader {
        display: flex;
        align-items: center;
        color: #FFFFFF;
        font-family: "Anton", sans-serif;
        font-size: 35px;
        transition: color 0.8 ease-in-out;
    }

    .logoHeader a {
        text-decoration: none;
    }

    .logoHeader p {
        margin-left: 7px;
    }

    header .icons img {
        width: 47px;
        height: 47px;
        filter: brightness(0) invert(1);
        /* deixa branco */
        transition: filter 0.8 ease-in-out;
    }

    .icons {
        display: flex;
        gap: 14px;
    }

    /* ===== ESTADO APÓS ROLAR ===== */
    header.scrolled {
        background-color: #FFFFFF;
        box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.404);
        padding: 0 25px;
    }

    header.scrolled .logoHeader img {
        content: url("https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png");
        width: 87px;
        height: 87px;
    }

    header.scrolled .logoHeader p {
        color: #000000;
    }

    header.scrolled nav a {
        color: #000000;
    }

    header.scrolled .logoHeader img {
        color: #000000;
    }

    header.scrolled .icons img {
        filter: brightness(0);
    }


    main {
        display: flex;
        width: 100%;
        overflow: hidden;
    }

    .conteiner {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 745px;
    }

    .conteiner img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .conteiner span {
        position: relative;
        z-index: 1;
        text-align: center;
        font-size: 94px;
        font-weight: bold;
        color: #000000;
        font-family: var(--fontePrimaria);
        background-color: #838383;
        border-radius: 8px;
        padding: 20px 34px;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
    }


    /* PARTE CATALOGO */

    .fundoPrincipal {
        background: var(--gradienteVertical2);
    }

    .outrasCategorias {
        padding-top: 50px;
        display: flex;
        flex-direction: column;
        gap: 25px;
        margin: 0 210px;
        font-family: var(--fontePrimaria);
    }

    .outrasCategorias h1 {
        color: #000000;
        font-size: 42px;

    }

    .categorias {
        display: flex;
        gap: 50px;
    }

    .categorias a {
        position: relative;
        text-decoration: none;
        color: #ffffff;
        font-size: 28px;
        cursor: pointer;
        display: inline-block;
    }

    .categorias a::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #1b1b1b;
        transition: width 0.3s ease-in-out;
    }

    .categorias a:hover::after {
        width: 100%;
    }





    .catalogoCategoria {
        display: grid;
        grid-template-columns: repeat(4, 224px);
        gap: 150px;
        font-family: Arial, sans-serif;
        justify-content: center;
        padding: 125px 0;
        margin: 0 210px;
    }

    .cardDisco {
        width: 224px;
        height: 253px;
        background: var(--gradienteCardDiscos);
        font-family: var(--fontePrimaria);
        border-radius: 5px;
        padding: 0px 7px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .cardDisco:hover {
        transform: scale(1.03);
    }

    .cardDisco .imgCard {
        cursor: pointer;
        padding-top: 6px;
        padding-left: 7px;
        padding-right: 9px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cardDisco .imgCard>img {
        max-width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .infoDisco {
        font-size: 15px;
        padding-bottom: 20px;
    }

    .infoDisco .precoDisco {
        padding-top: 4px;
        font-weight: bold;
        font-size: 20px;
    }


    .preçoEFavDisco {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .preçoEFavDisco button {
        border-radius: 3px;
        border: 1px solid #000000;
        padding: 2px 12px;
        font-family: var(--fontePrimaria);
        cursor: pointer;
        transition: background-color 0.1s ease-in-out, transform 0.1s ease-in-out;
    }

    .preçoEFavDisco button:hover {
        background-color: #acacac;
        color: #ffffff;
        border: 2.2px solid #ffffff;
        transform: scale(1.0);
        box-shadow: 12px 12px 12px 2px rgba(0, 0, 0, 0.2);
    }

    .preçoEFavDisco .favorite img {
        width: 20px;
        height: 20px;
        transition: color 0.8s ease-in-out;
        cursor: pointer;
    }

    .preçoEFavDisco .cart img {
        width: 20px;
        height: 20px;
        transition: color 0.8s ease-in-out;
        cursor: pointer;
    }

    .preçoEFavDisco .favorite img:hover {
        content: url("https://i.ibb.co/b5vJrSGP/favorite-Red.png");
    }

    .preçoEFavDisco .cart img:hover {
        content: url("https://i.ibb.co/DPg9f9c3/add-shopping-cart-3.png");
    }







    footer {
        background-color: #4C4C4C;
        color: white;
        padding: 30px;
        border-radius: 30px 30px 0px 0px;

    }

    .footerContainer {
        display: flex;
        justify-content: space-between;
        justify-content: center;
        justify-content: flex-start;
        gap: 238px;
    }

    .footerLogo img {
        width: 117px;
        height: 117px;
    }

    .footerLogo h1 {
        font-family: var(--fonteSecundaria);
        font-size: 35px;
        font-weight: 100;
        letter-spacing: 2px;
        line-height: 35px;
    }

    .footerLogo {
        display: flex;
        gap: 10px;
        flex-direction: column;
    }

    .socialConteiner {
        display: flex;
        justify-content: center;
        flex-direction: column;
        font-family: var(--fonteTerciaria);
        margin-right: 335px;
    }

    .socialConteiner hr {
        margin-top: 16px;
        margin-bottom: 11px;
    }


    .social {
        font-size: 24px;
        margin-top: 23px;
        margin-bottom: 15px;
    }


    .socialLogo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .socialLogo img {
        max-width: 30px;
    }

    .copyrightVdR {
        display: flex;
        justify-content: center;
        font-family: var(--fonteTerciaria);
        font-size: 24px;
        margin-top: 90px;
    }

    .footerCtt h1 {
        font-size: 30px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .formasPagamento hr {
        margin-top: 16px;
        margin-bottom: 11px;
    }

    .formasPagamentoImg {
        display: flex;
        align-items: center;
        gap: 15px;
    }
</style>

<body>



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
                        <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}" class="imgCard">
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

                        <button class="btnComprarAgora" onclick="window.location.href='{{ route('product.show', $p->id) }}'"
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

                            <a href="/whishlist">
                                <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
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

                        <img style="cursor: pointer;" onclick="window.open('https://www.instagram.com/', '_blank')"
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

</html>