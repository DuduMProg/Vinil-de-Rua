const btnFiltrar = document.querySelector(".btnFiltrar");
const btnLimpar  = document.querySelector(".btnLimpar");
const cards      = document.querySelectorAll(".cardDisco");
const filtrosPreco     = document.querySelectorAll(".filtroPreco");
const filtrosCategoria = document.querySelectorAll(".filtroCategoria");

btnFiltrar.addEventListener("click", () => {

    const precosAtivos = [...filtrosPreco]
        .filter(cb => cb.checked)
        .map(cb => Number(cb.value));

    const categoriasAtivas = [...filtrosCategoria]
        .filter(cb => cb.checked)
        .map(cb => cb.value.toLowerCase().trim());

    cards.forEach(card => {

        const preco     = parseFloat(card.getAttribute("data-preco")) || 0;
        const categoria = (card.getAttribute("data-categoria") || "").toLowerCase().trim();

        let passaPreco = true;
        if (precosAtivos.length > 0) {
            passaPreco = precosAtivos.some(valor => {
                if (valor === 100) return preco <= 100;
                if (valor === 200) return preco > 100 && preco <= 200;
                if (valor === 300) return preco > 200 && preco <= 300;
                if (valor === 400) return preco > 300 && preco <= 400;
                if (valor === 500) return preco > 400 && preco <= 500;
                return false;
            });
        }

        let passaCategoria = true;
        if (categoriasAtivas.length > 0) {
            passaCategoria = categoriasAtivas.includes(categoria);
        }

        card.style.display = (passaPreco && passaCategoria) ? "flex" : "none";
    });
});

btnLimpar.addEventListener("click", () => {
    filtrosPreco.forEach(cb => cb.checked = false);
    filtrosCategoria.forEach(cb => cb.checked = false);
    cards.forEach(card => card.style.display = "flex");
});

// ── Filtro mobile ──
const btnAbrir  = document.getElementById('btnAbrirFiltro');
const btnFechar = document.getElementById('btnFecharFiltro');
const sidebar   = document.getElementById('sidebarFiltro');
const overlay   = document.getElementById('overlayFiltro');

function abrirFiltro() {
    sidebar.classList.add('aberto');
    overlay.classList.add('ativo');
}

function fecharFiltro() {
    sidebar.classList.remove('aberto');
    overlay.classList.remove('ativo');
}

btnAbrir.addEventListener('click', abrirFiltro);
btnFechar.addEventListener('click', fecharFiltro);
overlay.addEventListener('click', fecharFiltro);

// ✅ Impede que cliques DENTRO do sidebar fechem o drawer
sidebar.addEventListener('click', (e) => {
    e.stopPropagation();
});