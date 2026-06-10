<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar - Vinil de Rua</title>

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
        <div class="containerCadastro">

            {{-- Área da imagem --}}
            <div class="imgCadastro">
                <img src="https://i.ibb.co/QRZzdTz/bg-Escuro.png" alt="">
                <img src="https://i.ibb.co/ycYCzc5P/bg-Claro.png" alt="">
                <img src="https://i.ibb.co/Wv5Vbg9b/img-Cadastro.png" alt="Vinil de Rua">
            </div>

            {{-- Formulário --}}
            <div class="criarConta">

                <div class="logoEmsg">
                    <div class="logoPerfil">
                        <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                        <h1>VINIL <br> DE RUA</h1>
                    </div>
                    <div class="mensagemBnv">
                        <p>Seja Bem-vindo(a) ao Vinil de Rua!</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="infoUser">

                        <label for="name">Nome de Usuário
                            <input type="text" id="name" name="name" placeholder="NOME" class="inputNome"
                                value="{{ old('name') }}" required>
                        </label>

                        <label for="email">Email
                            <input type="email" id="email" name="email" placeholder="EMAIL" class="inputEmail"
                                value="{{ old('email') }}" required>
                        </label>

                        <label for="password">Senha
                            <input type="password" id="password" name="password" placeholder="SENHA" class="inputSenha"
                                required>
                        </label>

                        <label for="password_confirmation">Confirmar Senha
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="CONFIRME A SENHA" class="inputSenha" required>
                        </label>

                        <label for="telefone">Telefone
                            <input type="text" id="telefone" name="telefone" placeholder="TELEFONE"
                                class="inputTelefone" value="{{ old('telefone') }}" maxlength="15">
                        </label>

                        <div class="campoCom2">
                            <label for="cep">CEP
                                <input type="text" id="cep" name="cep" placeholder="CEP" class="inputGps"
                                    value="{{ old('cep') }}" maxlength="9">
                            </label>

                            <label for="estado">Estado
                                <input type="text" id="estadoInput" name="estado" placeholder="ESTADO" class="inputGps"
                                    value="{{ old('estado') }}" maxlength="2">
                            </label>
                        </div>

                        <div class="campoCom2">
                            <label for="cidade">Cidade
                                <input type="text" id="cidade" name="cidade" placeholder="CIDADE" class="inputGps"
                                    value="{{ old('cidade') }}">
                            </label>

                            <label for="endereco">Endereço
                                <input type="text" id="endereco" name="endereco" placeholder="ENDEREÇO" class="inputGps"
                                    value="{{ old('endereco') }}">
                            </label>
                        </div>

                        <div class="buttonOk">
                            <button type="submit" id="buttonOk" onclick="open.window('/')">CADASTRAR</button>
                        </div>

                        <div class="anchorUser">
                            <a href="{{ route('login') }}">Voltar ao login</a>
                        </div>

                    </div>

                </form>

            </div>

        </div>
    </main>

    @vite('resources/js/loading.js')
    @vite('resources/js/login.js')

    <script>

        // ── Máscara CEP (formata enquanto digita) ──
        document.getElementById('cep')?.addEventListener('input', function () {
            let valor = this.value.replace(/\D/g, '');

            if (valor.length > 5) {
                valor = valor.slice(0, 5) + '-' + valor.slice(5, 8);
            }

            this.value = valor;
        });

        // ── ViaCEP — preenche endereço automaticamente ──
        document.getElementById('cep')?.addEventListener('blur', function () {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length !== 8) return;

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(res => res.json())
                .then(data => {
                    if (data.erro) return;
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estadoInput').value = data.uf;
                });
        });

        document.getElementById('telefone')?.addEventListener('input', function () {
            let d = this.value.replace(/\D/g, '').slice(0, 11);

            if (d.length === 0) { this.value = ''; return; }

            let valor = '(' + d.substring(0, 2);
            if (d.length > 2) valor += ') ' + d.substring(2, 7);
            if (d.length > 7) valor += '-' + d.substring(7, 11);

            this.value = valor;
        });

    </script>

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