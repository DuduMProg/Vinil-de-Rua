{{-- resources/views/profile/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>

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

            <h1>
                Perfil /
                <span>Meu Perfil</span>
            </h1>

            <div class="linksSecao">

                <a href="{{ route('profile.index') }}" class="pageOff">
                    Gerenciar minha Conta
                </a>

                <a href="{{ route('profile.orders') }}" class="pageOn">
                    Meus Pedidos
                </a>

                <a href="{{ route('profile.recent') }}" class="pageOff">
                    Vistos Recentemente
                </a>

            </div>

        </div>

        <div class="meusPedidos">

            @if($orders->isEmpty())
                <p class="semPedidos">Você ainda não fez nenhum pedido.</p>
                <a href="/product" class="btnVerProdutos">Ver produtos</a>
            @else
                <table class="tabelaPedidos">
                    <thead>
                        <tr>
                            <th>Produto(s)</th>
                            <th>Total</th>
                            <th>Pagamento</th>
                            <th>Data</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="tdProdutos">
                                    @foreach($order->items as $item)
                                        @php $cover = $item->product->images->first(); @endphp
                                        <div class="itemPedido">
                                            @if($cover)
                                                <img src="{{ $cover->path }}" alt="{{ $item->product->name }}">
                                            @endif
                                            <a href="/product/{{ $item->product->id }}">
                                                {{ Str::limit($item->product->name, 20) }}
                                            </a>
                                            <span>x{{ $item->units }}</span>
                                        </div>
                                    @endforeach
                                </td>

                                <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>

                                <td>{{ $order->payment_label }}</td>

                                <td>{{ $order->created_at->format('d/m/Y') }}</td>

                                <td>
                                    <span class="statusPedido status-{{ $order->status }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>

    </main>

    

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')
    

</body>

</html>