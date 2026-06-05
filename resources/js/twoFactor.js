document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.code-input');
    const form = document.querySelector('form');

    inputs.forEach((input, index) => {

        input.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');

            e.target.value = value;

            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {

            if (e.key === 'Backspace') {

                if (input.value) {
                    input.value = '';
                } else if (index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                }

                e.preventDefault();
            }

            if (e.key === 'ArrowLeft' && index > 0) {
                inputs[index - 1].focus();
            }

            if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
    });

    // Cola o código inteiro
    inputs[0].addEventListener('paste', (e) => {
        e.preventDefault();

        const codigo = e.clipboardData
            .getData('text')
            .replace(/\D/g, '')
            .slice(0, inputs.length);

        codigo.split('').forEach((numero, i) => {
            if (inputs[i]) {
                inputs[i].value = numero;
            }
        });

        const ultimo = Math.min(codigo.length, inputs.length) - 1;

        if (ultimo >= 0) {
            inputs[ultimo].focus();
        }
    });

    form.addEventListener('submit', () => {
        const codigo = [...inputs]
            .map(input => input.value)
            .join('');

        document.getElementById('codigo-completo').value = codigo;
    });
});