{{-- resources/views/profile/partials/update-password-form.blade.php --}}

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    @if(session('status') === 'password-updated')
        <p style="color:green; margin-bottom:10px">Senha atualizada com sucesso!</p>
    @endif

    <div class="campoInfo">
        <label for="current_password">Senha Atual</label>
        <input type="password" id="current_password" name="current_password"
               class="inputPerfil" required>
        @error('current_password', 'updatePassword')
            <p style="color:red; font-size:13px">{{ $message }}</p>
        @enderror
    </div>

    <div class="campoInfo">
        <label for="password">Nova Senha</label>
        <input type="password" id="password" name="password"
               class="inputPerfil" required>
        @error('password', 'updatePassword')
            <p style="color:red; font-size:13px">{{ $message }}</p>
        @enderror
    </div>

    <div class="campoInfo">
        <label for="password_confirmation">Confirmar Nova Senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="inputPerfil" required>
        @error('password_confirmation', 'updatePassword')
            <p style="color:red; font-size:13px">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btnSalvar">Atualizar senha</button>

</form>