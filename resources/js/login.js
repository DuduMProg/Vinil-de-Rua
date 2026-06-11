

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

// Toggle esqueceu a senha
document.getElementById('linkEsqueceuSenha')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.containerLogin').style.display = 'none';
    document.getElementById('forgotBox').style.display = 'block';
});

document.getElementById('linkVoltarLogin')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('forgotBox').style.display = 'none';
    document.querySelector('.containerLogin').style.display = 'flex';
});

// Toggle mostrar/esconder senha
const inputSenha  = document.getElementById('password');
const toggleSenha = document.getElementById('toggleSenha');
toggleSenha?.addEventListener('click', function() {
    inputSenha.type = inputSenha.type === 'text' ? 'password' : 'text';
});

// ── Máscara CEP (formata enquanto digita) ──
document.getElementById('cep')?.addEventListener('input', function () {
    let valor = this.value.replace(/\D/g, '');

    if (valor.length > 5) {
        valor = valor.slice(0, 5) + '-' + valor.slice(5, 8);
    }

    this.value = valor;
});



