<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Verificação em duas etapas</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

</head>
@vite('resources/css/styleLoginRegister.css')

<body>

    <main>
        <div class="autenticacao">

            <h1>Verificação em duas etapas</h1>
            <p>Enviamos um código de 6 dígitos para o seu e-mail.</p>

            {{-- Código visível na tela enquanto não há serviço de e-mail --}}
            @if(isset($code))
                <div class="codigoVisivel">
                    <p>Seu código de acesso:</p>
                    <strong>{{ $code }}</strong>
                </div>
            @endif
            @if (session('status'))
                <p style="color: green;">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <ul style="color: red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('2fa.verify') }}" class="formCodigo">
                @csrf
                <label>Código:</label>

                <div class="code-container">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input" autofocus>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="code-input">
                </div>

                <input type="hidden" name="code" id="codigo-completo">

                <button type="submit">Verificar</button>

            </form>

            <form method="POST" action="{{ route('2fa.resend') }}" class="formReenviar">
                @csrf
                <button type="submit">Reenviar código</button>
            </form>
        </div>
    </main>

    @vite('resources/js/twoFactor.js')
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