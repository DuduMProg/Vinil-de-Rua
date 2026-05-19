<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar - Vinil de Rua</title>
    @vite('resources/css/stylePerfil.css')
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <main>
        <div class="form-container">

            <div class="criarConta-box form-box">

                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>

                <div class="mensagemErro">
                    <h1>Seja Bem-vindo(a) ao Vinil de Rua!</h1>
                </div>

                @if($errors->any())
                    <div class="mensagemErro">
                        @foreach($errors->all() as $error)
                            <p style="color:red">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="infoUser">

                        {{-- Breeze exige: name, email, password, password_confirmation --}}
                        <input type="text" name="name" placeholder="NOME"
                               class="inputEmail" value="{{ old('name') }}" required>

                        <input type="email" name="email" placeholder="EMAIL"
                               class="inputEmail" value="{{ old('email') }}" required>

                        <input type="password" name="password" placeholder="SENHA"
                               class="inputSenha" required>

                        <input type="password" name="password_confirmation"
                               placeholder="CONFIRME A SENHA" class="inputSenha" required>

                        {{-- Campos extras — não são do Breeze mas podem ser salvos depois --}}
                        <input type="tel" name="telefone" placeholder="TELEFONE"
                               class="inputTelefone" value="{{ old('telefone') }}">

                        <input type="text" name="cep" placeholder="CEP"
                               class="inputGps" value="{{ old('cep') }}">

                        <input type="text" name="endereco" placeholder="ENDEREÇO"
                               class="inputGps" value="{{ old('endereco') }}">

                        <input type="text" name="complemento" placeholder="COMPLEMENTO"
                               class="inputGps" value="{{ old('complemento') }}">

                        <input type="text" name="cidade" placeholder="CIDADE"
                               class="inputGps" value="{{ old('cidade') }}">

                        <input type="text" name="estado" placeholder="ESTADO"
                               class="inputGps" id="estadoInput" value="{{ old('estado') }}">

                    </div>

                    <div class="cadastrarUser">
                        <button type="submit" id="cadastrarUser">CADASTRAR</button>
                    </div>

                </form>

                <div class="voltarLogin">
                    <span>
                        <a href="{{ route('login') }}">Voltar ao login</a>
                    </span>
                </div>

            </div>
        </div>
    </main>

    @vite('resources/js/loading.js')
    @vite('resources/js/login.js')

</body>

</html>