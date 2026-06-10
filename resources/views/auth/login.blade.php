<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/styleLoginRegister.css')
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <main>
        <div class="containerLogin">

            {{-- Formulário --}}
            <div class="login">

                <div class="logoEmsg">
                    <div class="logoPerfil">
                        <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                        <h1>VINIL <br> DE RUA</h1>
                    </div>
                    <div class="welcomeBack">
                        <p>Seja Bem Vindo (a) de volta!</p>
                    </div>
                </div>

                {{-- Erros de validação --}}
                @if($errors->any())
                    <div style="color:red; margin-bottom:10px">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="infoUser">

                        <label for="email">Email
                            <input type="email" id="email" name="email" placeholder="EMAIL"
                                   class="inputEmail" value="{{ old('email') }}" required>
                        </label>

                        <label for="password">Senha
                            <input type="password" id="password" name="password"
                                   placeholder="SENHA" class="inputSenha" required>
                        </label>

                        <div class="anchorUser">
                            <a href="{{ route('password.email') }}" id="linkEsqueceuSenha">Esqueci a senha</a>
                        </div>

                        <div class="buttonOk">
                            <button type="submit" id="buttonOk">Entrar</button>
                        </div>

                        <div class="anchorUser">
                            <a href="{{ route('register') }}">Criar conta</a>
                        </div>

                    </div>

                </form>

            </div>

            {{-- Área da imagem --}}
            <div class="imgLogin">
                <img src="https://i.ibb.co/XrVxZWss/bg-Escuro-L.png" alt="">
                <img src="https://i.ibb.co/B57fVCwp/bg-Clarp-L.png" alt="">
                <img src="https://i.ibb.co/vbDptCn/foto-Login.png" alt="Vinil de Rua">
            </div>

        </div>

        {{-- Recuperar Senha — aparece via JS --}}
        <div class="forgot-box" id="forgotBox" style="display:none">

            <div class="logoPerfil">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                <h1>VINIL <br> DE RUA</h1>
            </div>

            <p>Calma! Iremos recuperar sua senha.</p>

            @if(session('status'))
                <p style="color:green">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label for="emailRecuperar">Email
                    <input type="email" id="emailRecuperar" name="email"
                           placeholder="EMAIL" class="inputEmail"
                           value="{{ old('email') }}" required>
                </label>
                <div class="buttonOk">
                    <button type="submit">ENVIAR</button>
                </div>
            </form>

            <div class="anchorUser">
                <a href="#" id="linkVoltarLogin">Voltar ao login</a>
            </div>

        </div>

    </main>

    @vite('resources/js/loading.js')
    @vite('resources/js/login.js')

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