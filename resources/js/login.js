const container = document.querySelector('.form-container');

document.getElementById('linkEsqueceuSenha')?.addEventListener('click', function (e) {
    e.preventDefault();
    container.classList.add('show-forgot');
});

document.getElementById('linkVoltarLogin')?.addEventListener('click', function (e) {
    e.preventDefault();
    container.classList.remove('show-forgot');
});

document.getElementById('criarConta')?.addEventListener('click', function () {
    window.location.href = '{{ route("register") }}';
});

const inputSenha = document.getElementById('inputSenhaField');
const toggleSenha = document.getElementById('toggleSenha');

toggleSenha?.addEventListener('click', function () {
    inputSenha.type = inputSenha.type === 'text' ? 'password' : 'text';
});


document.addEventListener('DOMContentLoaded', function () {

    const cepInput = document.querySelector('input[name="cep"]');

    cepInput?.addEventListener('blur', function () {
        const cep = this.value.replace(/\D/g, ''); // remove tudo que não é número

        if (cep.length !== 8) return; // CEP tem 8 dígitos

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado.');
                    return;
                }

                // Preenche os campos automaticamente
                document.querySelector('input[name="endereco"]').value  = data.logradouro;
                document.querySelector('input[name="complemento"]').value = data.complemento;
                document.querySelector('input[name="cidade"]').value    = data.localidade;
                document.querySelector('input[name="estado"]').value    = data.uf;
            })
            .catch(() => alert('Erro ao buscar CEP.'));
    });

});