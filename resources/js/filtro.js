const btnFiltrar = document.querySelector(".btnFiltrar");
const btnLimpar = document.querySelector(".btnLimpar");

const cards = document.querySelectorAll(".cardDisco");
const filtrosPreco = document.querySelectorAll(".filtroPreco");

btnFiltrar.addEventListener("click", () => {

    const selecionados = [...filtrosPreco]
        .filter(cb => cb.checked)
        .map(cb => Number(cb.value));

    // nenhum filtro marcado
    if (selecionados.length === 0) {

        cards.forEach(card => {
            card.style.display = "flex";
        });

        return;
    }

    cards.forEach(card => {

        const preco = Number(card.getAttribute("preco"));

        let mostrar = false;

        selecionados.forEach(valor => {

            if (valor === 100 && preco <= 100) {
                mostrar = true;
            }

            if (valor === 200 && preco > 100 && preco <= 200) {
                mostrar = true;
            }

            if (valor === 300 && preco > 200 && preco <= 300) {
                mostrar = true;
            }
            if (valor === 400 && preco > 300 && preco <= 400) {
                mostrar = true;
            }

        });

        card.style.display = mostrar ? "flex" : "none";

    });

});
btnLimpar.addEventListener("click", () => {

    filtrosPreco.forEach(cb => {
        cb.checked = false;
    });

    cards.forEach(card => {
        card.style.display = "flex";
    });

});