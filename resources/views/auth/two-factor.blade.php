<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Verificação em duas etapas</title>
</head>
@vite('resources/css/styleLoginRegister.css')

<body>

    <main>
        <div class="autenticacao">

            <h1>Verificação em duas etapas</h1>
            <p>Enviamos um código de 6 dígitos para o seu e-mail.</p>
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
            <form method="POST" action="{{ route('2fa.verify') }}">
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

            <form method="POST" action="{{ route('2fa.resend') }}">
                @csrf
                <button type="submit">Reenviar código</button>
            </form>
        </div>
    </main>

    @vite('resources/js/twoFactor.js')

</body>

</html>