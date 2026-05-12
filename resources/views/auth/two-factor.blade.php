<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Verificação em duas etapas</title>
</head>

<body>
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
        <label for="code">Código:</label>
        <input id="code" name="code" type="text" inputmode="numeric" maxlength="6" required autofocus>
        <button type="submit">Verificar</button>
    </form>
    <form method="POST" action="{{ route('2fa.resend') }}">
        @csrf
        <button type="submit">Reenviar código</button>
    </form>
</body>

</html>