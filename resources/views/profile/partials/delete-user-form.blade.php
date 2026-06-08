{{-- resources/views/profile/partials/delete-user-form.blade.php --}}

<div class="zonaPerigo">

    <p style="font-family: var(--fonteTerciaria); color:#842029; margin-bottom:15px">
        Atenção: ao deletar sua conta, todos os seus dados serão permanentemente removidos.
    </p>

    {{-- Botão que abre o modal de confirmação --}}
    <button type="button" id="btnAbrirModal" class="btnDeletar">
        Deletar minha conta
    </button>

    {{-- Modal de confirmação --}}
    <div id="modalDeletar" style="display:none; position:fixed; inset:0;
         background:rgba(0,0,0,0.6); z-index:9999;
         justify-content:center; align-items:center;">

        <div style="background:#fff; padding:30px; border-radius:10px;
                    max-width:450px; width:90%;">

            <h2 style="font-family: var(--fontePrimaria); margin-bottom:15px">
                Tem certeza?
            </h2>

            <p style="font-family: var(--fonteTerciaria); margin-bottom:20px; font-size:14px">
                Esta ação não pode ser desfeita. Digite sua senha para confirmar.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="campoInfo" style="margin-bottom:15px">
                    <label for="password_delete">Sua senha</label>
                    <input type="password" id="password_delete" name="password"
                           class="inputPerfil" placeholder="Digite sua senha" required>
                    @error('password', 'userDeletion')
                        <p style="color:red; font-size:13px">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end">
                    <button type="button" id="btnFecharModal" class="btnCancelar">
                        Cancelar
                    </button>
                    <button type="submit" class="btnDeletar">
                        Confirmar exclusão
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    const modalDeletar  = document.getElementById('modalDeletar');
    const btnAbrirModal = document.getElementById('btnAbrirModal');
    const btnFecharModal = document.getElementById('btnFecharModal');

    btnAbrirModal?.addEventListener('click', () => {
        modalDeletar.style.display = 'flex';
    });

    btnFecharModal?.addEventListener('click', () => {
        modalDeletar.style.display = 'none';
    });

    // Fecha ao clicar fora do box
    modalDeletar?.addEventListener('click', (e) => {
        if (e.target === modalDeletar) {
            modalDeletar.style.display = 'none';
        }
    });
</script>