{{-- resources/views/cart/index.blade.php --}}

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vinil de Rua - Home</title>

    {{-- FONTES --}}
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    {{-- CSS --}}
    @vite('resources/css/index.css')

    <link rel="shortcut icon" type="imagex/png" href="/src/assets/images/logoVinilDeRua.svg">
</head>

<body>

    <header>

        <div class="logoHeader">

            <a href="/">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo-Vinil-De-Rua">
            </a>

            <p>
                VINIL <br>DE RUA
            </p>

        </div>

        <nav>

            <a href="/#catalogo">Cátalogo</a>

            <a href="/src/assets/pages/pageOff.html#catalogoOff">
                Ofertas
            </a>

            <a href="#contato">Contato</a>

        </nav>

        <div class="icons">
            <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite" onclick="openSidebar('wishlist')">
            <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart" onclick="openSidebar('cart')">
            <a href="/perfil">
                <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
            </a>
        </div>

        {{-- Overlay --}}
        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

        {{-- Sidebar --}}
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 id="sidebar-title">Carrinho</h2>
                <button onclick="closeSidebar()">✖</button>
            </div>
            <div class="sidebar-content">

                @if(session('error'))
                    <p style="color: red">{{ session('error') }}</p>
                @endif

                @if($cart->items->isEmpty())
                    <p>Seu carrinho está vazio.</p>

                    <a href="#">Se pudermos fazer algumas sugestões...</a>
                @else

                    @php $total = 0; @endphp

                    @foreach($cart->items as $i)

                        @php
                            $subtotal = $i->units * $i->product->price;

                            $total += $subtotal;

                            $cover =
                                $i->product->images->firstWhere('is_cover', true)
                                ?? $i->product->images->first();
                        @endphp

                        <div class="produtoItem">
                            @if($cover)
                                <img src="{{ $cover->path }}" alt="{{ $i->product->name }}" class="imgProdCart">
                            @endif

                            <div class="nomeProd">
                                <p>{{ $i->product->name }}</p>
                                <div class="qntdProd">
                                    {{-- decrementa --}}
                                    <form action="/cart/decrement/{{ $i->product_id }}" method="POST">
                                        @csrf
                                        <button type="submit">-</button>
                                    </form>

                                    <span>{{ $i->units }}</span>

                                    {{-- incrementa --}}
                                    <form action="/cart/store/{{ $i->product_id }}" method="POST">
                                        @csrf

                                        <button type="submit">+</button>
                                    </form>
                                </div>
                            </div>
                            <div class="deletePrice">

                                <form action="/cart/delete/{{ $i->product_id }}" method="POST"
                                    onsubmit="return confirm('Remover {{ $i->product->name }}?')">
                                    @csrf

                                    <button type="submit" class="deleteBtn"><img src="https://i.ibb.co/Zzdfgwmf/delete.png"
                                            class="deleteIcon" alt="deletar"></button>

                                </form>

                                <p>R$ {{ number_format($subtotal, 2, ',', '.') }}</p>

                            </div>
                        </div>

                    @endforeach

                    <div class="cartTotal">

                        <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>

                    </div>

                @endif

            </div>

            <div class="btnResumo">

                <a href="/checkout">

                    <button>Resumo da compra</button>

                </a>

            </div>

        </div>

    </header>


    @vite('resources/js/index.js')
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

</body>

</html>