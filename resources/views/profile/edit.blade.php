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

    @vite('resources/css/styelePerfil.css')

    <link rel="shortcut icon" type="imagex/png"
        href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <main>

        <hr>

        <div class="secoesUser">

            <h1>
                Perfil /
                <span>Editar Perfil</span>
            </h1>

            <div class="linksSecao">

                <a href="{{ route('profile.index') }}" class="pageOff">
                    Gerenciar minha Conta
                </a>

                <a href="{{ route('profile.orders') }}" class="pageOff">
                    Meus Pedidos
                </a>

                <a href="{{ route('profile.recent') }}" class="pageOff">
                    Vistos Recentemente
                </a>

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
            <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
                alt="Vinil de Rua"
                class="logo">

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