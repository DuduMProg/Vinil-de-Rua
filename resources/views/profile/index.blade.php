<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/perfil.css')
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body class="fundoPrincipal">

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    {{-- Header --}}
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

            <a href="/profile">
                <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
            </a>

            {{-- Botão de sair --}}
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btnLogout">Sair</button>
            </form>
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

        <hr>

        {{-- Navegação do perfil --}}
        <div class="secoesUser">
            <h1>Perfil/ <span>Meu Perfil</span></h1>
            <div class="linksSecao">
                <a href="/profile/index" class="pageOn">Gerenciar minha Conta</a>
                <a href="/profile/orders" class="pageOff">Meus Pedidos</a>
                <a href="/profile/recently-viewed" class="pageOff">Vistos Recentemente</a>
            </div>
        </div>

        {{-- Informações do usuário --}}
        <div class="infoUser">

            @if(session('status') === 'profile-updated')
                <p style="color:green">Perfil atualizado com sucesso!</p>
            @endif

            <div class="saudacaoUser">
                <h1>Olá, {{ auth()->user()->name }}</h1>
            </div>

            <div class="lado1E2">

                <div class="lado1User">

                    <div class="campoInfo">
                        <h1>Nome de Usuário</h1>
                        <p>{{ auth()->user()->name }}</p>
                    </div>

                    <div class="campoInfo">
                        <h1>Telefone</h1>
                        <p>{{ auth()->user()->telefone ?? '—' }}</p>
                    </div>

                    <div class="campoCom2">
                        <div class="campoInfo">
                            <h1>Cidade</h1>
                            <p>{{ auth()->user()->cidade ?? '—' }}</p>
                        </div>
                        <div class="campoInfo">
                            <h1>Endereço</h1>
                            <p>{{ auth()->user()->endereco ?? '—' }}</p>
                        </div>
                    </div>

                </div>

                <div class="lado2User">

                    <div class="campoInfo">
                        <h1>Email</h1>
                        <p>{{ auth()->user()->email }}</p>
                    </div>

                    <div class="campoCom2">
                        <div class="campoInfo">
                            <h1>CEP</h1>
                            <p>{{ auth()->user()->cep ?? '—' }}</p>
                        </div>
                        <div class="campoInfo">
                            <h1>Estado</h1>
                            <p>{{ auth()->user()->estado ?? '—' }}</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="botaoEdit">
                <button onclick="window.location.href='/profile/edit'">Editar informações</button>
            </div>

        </div>

    </main>

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')

</body>

</html>