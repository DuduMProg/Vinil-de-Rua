{{-- resources/views/profile/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

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

        <div class="secoesUser">
            <h1>Perfil/ <span>Meu Perfil</span></h1>
            <div class="linksSecao">
                <a href="/profile/index" class="pageOn">Gerenciar minha Conta</a>
                <a href="/profile/orders" class="pageOff">Meus Pedidos</a>
                <a href="/profile/recently-viewed" class="pageOff">Vistos Recentemente</a>
            </div>
        </div>

        <div class="infoUser">

            <div class="saudacaoUser">
                <h1>Olá, {{ Auth::user()->name }}</h1>
            </div>

            <div class="lado1E2">

                {{-- DADOS DA CONTA --}}
                <div class="lado1User">

                    <div class="campoInfo">
                        <h1>Informações da Conta</h1>

                        <div class="mt-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                </div>

                {{-- SENHA --}}
                <div class="lado2User">

                    <div class="campoInfo">
                        <h1>Alterar Senha</h1>

                        <div class="mt-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                </div>

            </div>

            <div class="botaoEdit">

                <a href="{{ route('profile.index') }}">
                    <button type="button">
                        Voltar ao Perfil
                    </button>
                </a>

            </div>

        </div>

        {{-- EXCLUSÃO DE CONTA --}}
        <div class="infoUser" style="margin-top: 30px;">

            <div class="saudacaoUser">
                <h1>Zona de Perigo</h1>
            </div>

            @include('profile.partials.delete-user-form')

        </div>

    </main>

    <footer id="contato">

        <div class="footerLogo">
            <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">

            <h1>
                VINIL <br>DE RUA
            </h1>
        </div>

        <div class="avisosFooter">
            <p>Duvidas? (11) 4002-8922 (SP)</p>
            <p>Seg a Sex, 9h às 21h Sáb 10h às 18h</p>
        </div>

        <div class="termos">
            <a id="openTerms" style="cursor:pointer;">
                Termos e Condições
            </a>
        </div>

    </footer>

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')
    @vite('resources/js/telaDeCompra.js')
    @vite('resources/js/popup.js')

</body>

</html>