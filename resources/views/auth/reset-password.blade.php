<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/styleLoginRegister.css')
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>



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
                        <p>Crie sua nova senha.</p>
                    </div>
                </div>

                {{-- Erros --}}
                @if($errors->any())
                    <div style="color:red; margin-bottom:10px">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <p class="instrucaoSenha">
                    Escolha uma senha segura para proteger sua conta no Vinil de Rua.
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <div class="infoUser">

                        <label for="email">Email
                            <input type="email" id="email" name="email" placeholder="EMAIL" class="inputEmail"
                                value="{{ old('email', request()->query('email', '')) }}" required autofocus
                                autocomplete="username">
                        </label>

                        <label for="password">Nova senha
                            <input type="password" id="password" name="password" placeholder="NOVA SENHA"
                                class="inputSenha" required autocomplete="new-password">
                        </label>

                        <label for="password_confirmation">Confirmar nova senha
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="CONFIRME A NOVA SENHA" class="inputSenha" required
                                autocomplete="new-password">
                        </label>

                        <div class="buttonOk">
                            <button type="submit">Redefinir senha</button>
                        </div>

                        <div class="anchorUser">
                            <a href="{{ route('login') }}">Voltar ao login</a>
                        </div>

                    </div>
                </form>

            </div>

            {{-- Área da imagem — mesma do login --}}
            <div class="imgLogin">
                <img src="https://i.ibb.co/XrVxZWss/bg-Escuro-L.png" alt="">
                <img src="https://i.ibb.co/B57fVCwp/bg-Clarp-L.png" alt="">
                <img src="https://i.ibb.co/vbDptCn/foto-Login.png" alt="Vinil de Rua">
            </div>

        </div>
    </main>

    @vite('resources/js/loading.js')

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