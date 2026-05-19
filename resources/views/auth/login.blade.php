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
    <!-- SEPARAÇÃO -->
    @vite('resources/css/stylePerfil.css')
    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">

</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <main>
        <div class="form-container">

            {{-- ── Login ── --}}
            <div class="login-box form-box">

                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>

                @if($errors->any())
                    <div class="mensagemErro">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="infoUser">

                        <input type="email" name="email" placeholder="EMAIL"
                               class="inputUser" value="{{ old('email') }}" required>

                        <div id="input" class="inputSenha">
                            <input type="password" name="password" placeholder="SENHA"
                                   class="inputPass" id="inputSenhaField" required>
                            <img src="https://i.ibb.co/0R4T4YRv/olhoDeR.png"
                                 alt="mostrar senha" id="toggleSenha" style="cursor:pointer">
                        </div>

                        <label>
                            <input type="checkbox" name="remember"> Lembrar de mim
                        </label>

                    </div>

                    <div class="buttonLogin">
                        <button href="{{ route('register') }}">Criar Conta</button>
                        <button type="submit" id="login">LOGIN</button>
                    </div>

                </form>

                <div class="esqueceuSenha">
                    <span><a href="#" id="linkEsqueceuSenha">Esqueceu a sua senha?</a></span>
                </div>

            </div>

            {{-- ── Recuperar Senha ── --}}
            <div class="forgot-box form-box">

                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>

                <div class="mensagemErro">
                    <h1>Calma! Iremos recuperar sua senha.</h1>
                </div>

                @if(session('status'))
                    <p style="color:green">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="infoUser">
                        <input type="email" name="email" placeholder="EMAIL"
                               class="inputUser" value="{{ old('email') }}" required>
                    </div>

                    <div class="buttonLogin">
                        <button type="submit" id="recuperarSenha">ENVIAR</button>
                    </div>

                </form>

                <div class="esqueceuSenha">
                    <span><a href="#" id="linkVoltarLogin">Voltar ao login</a></span>
                </div>

            </div>

        </div>
    </main>

    @vite('resources/js/loading.js')
    @vite('resources/js/login.js')

    

</body>

</html>