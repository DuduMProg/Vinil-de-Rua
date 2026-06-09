// ── Logout dropdown ──
const btnUsuario = document.getElementById('btnUsuario');
const menuLogout = document.getElementById('menuLogout');

if (btnUsuario && menuLogout) {
    btnUsuario.addEventListener('click', () => {
        menuLogout.classList.toggle('ativo');
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.areaUsuario')) {
            menuLogout.classList.remove('ativo');
        }
    });
}

// ── Filtro e busca ──
let filtroAtivo = 'todos';

function filtrar() {
    const busca   = document.getElementById('inputBusca')?.value.toLowerCase().trim() ?? '';
    const cards   = document.querySelectorAll('.adminCard');
    let visiveis  = 0;

    cards.forEach(card => {
        const nome    = card.dataset.nome    || '';
        const artista = card.dataset.artista || '';
        const tag     = card.dataset.tag     || '';
        const estoque = parseInt(card.dataset.estoque) || 0;
        const imagens = parseInt(card.dataset.imagens) || 0;

        const matchBusca = busca === '' || nome.includes(busca) || artista.includes(busca);

        let matchFiltro = true;
        switch (filtroAtivo) {
            case 'oferta':       matchFiltro = tag === 'oferta';  break;
            case 'index':        matchFiltro = tag === 'index';   break;
            case 'destaque':     matchFiltro = tag === 'destaque'; break;
            case 'estoque-baixo': matchFiltro = estoque <= 5;     break;
            case 'sem-tag':      matchFiltro = tag === '';        break;
            case 'sem-imagem':   matchFiltro = imagens === 0;     break;
            default:             matchFiltro = true;
        }

        if (matchBusca && matchFiltro) {
            card.classList.remove('oculto');
            visiveis++;
        } else {
            card.classList.add('oculto');
        }
    });

    const total = cards.length;
    const contador = document.getElementById('contadorResultados');
    if (contador) {
        contador.textContent = visiveis === total
            ? `${total} produto(s)`
            : `${visiveis} de ${total} produto(s)`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Busca em tempo real
    document.getElementById('inputBusca')?.addEventListener('input', filtrar);

    // Filtros — usando addEventListener ao invés de onclick inline
    document.querySelectorAll('.btnFiltro').forEach(btn => {
        btn.addEventListener('click', () => {
            filtroAtivo = btn.dataset.filtro;
            document.querySelectorAll('.btnFiltro').forEach(b => b.classList.remove('ativo'));
            btn.classList.add('ativo');
            filtrar();
        });
    });

    // Inicializa contador
    const total = document.querySelectorAll('.adminCard').length;
    const contador = document.getElementById('contadorResultados');
    if (contador) contador.textContent = `${total} produto(s)`;
});