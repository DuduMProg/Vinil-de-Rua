{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    @if(session('status') === 'profile-updated')
        <p style="color:green; margin-bottom:10px">Perfil atualizado com sucesso!</p>
    @endif

    <div class="campoInfo">
        <label for="name">Nome</label>
        <input type="text" id="name" name="name"
               value="{{ old('name', $user->name) }}"
               class="inputPerfil" required>
        @error('name')
            <p style="color:red; font-size:13px">{{ $message }}</p>
        @enderror
    </div>

    <div class="campoInfo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', $user->email) }}"
               class="inputPerfil" required>
        @error('email')
            <p style="color:red; font-size:13px">{{ $message }}</p>
        @enderror
    </div>

    <div class="campoInfo">
        <label for="telefone">Telefone</label>
        <input type="tel" id="telefone" name="telefone"
               value="{{ old('telefone', $user->telefone) }}"
               class="inputPerfil">
    </div>

    <div class="campoCom2">
        <div class="campoInfo">
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep"
                   value="{{ old('cep', $user->cep) }}"
                   class="inputPerfil" maxlength="9">
        </div>
        <div class="campoInfo">
            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado"
                   value="{{ old('estado', $user->estado) }}"
                   class="inputPerfil" maxlength="2">
        </div>
    </div>

    <div class="campoCom2">
        <div class="campoInfo">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade"
                   value="{{ old('cidade', $user->cidade) }}"
                   class="inputPerfil">
        </div>
        <div class="campoInfo">
            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco"
                   value="{{ old('endereco', $user->endereco) }}"
                   class="inputPerfil">
        </div>
    </div>

    <button type="submit" class="btnSalvar">Salvar alterações</button>

</form>

<script>
    // ViaCEP — preenche automaticamente ao sair do campo CEP
    document.getElementById('cep')?.addEventListener('blur', function () {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length !== 8) return;

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                if (data.erro) return;
                document.getElementById('endereco').value = data.logradouro;
                document.getElementById('cidade').value   = data.localidade;
                document.getElementById('estado').value   = data.uf;
            });
    });
</script>