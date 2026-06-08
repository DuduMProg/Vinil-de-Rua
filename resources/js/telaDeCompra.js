(function () {
    // Coleta todas as imagens do produto em ordem
    const imagens = [];
    document.querySelectorAll('.imgProduto img').forEach(img => {
        imagens.push({ src: img.src, alt: img.alt });
    });

    if (imagens.length === 0) return;

    let atual  = 0;
    let zoomed = false;

    const lb     = document.getElementById('lb');
    const lbImg  = document.getElementById('lb-img');
    const lbWrap = document.getElementById('lb-wrap');
    const lbCont = document.getElementById('lb-contador');
    const lbMinis= document.getElementById('lb-minis');

    // Monta as miniaturas no rodapé do lightbox
    function buildMinis() {
        lbMinis.innerHTML = '';
        imagens.forEach((im, i) => {
            const m = document.createElement('img');
            m.src = im.src;
            m.alt = im.alt;
            m.className = 'lb-mini' + (i === atual ? ' ativa' : '');
            m.addEventListener('click', () => irPara(i));
            lbMinis.appendChild(m);
        });
    }

    // Troca de imagem com slide suave
    function irPara(idx, dir = 'right') {
        if (idx === atual) return;
        zerarZoom();
        lbImg.classList.add('trocando', dir === 'left' ? 'esq' : '');

        setTimeout(() => {
            atual = idx;
            lbImg.src = imagens[atual].src;
            lbImg.alt = imagens[atual].alt;
            lbCont.textContent = (atual + 1) + ' / ' + imagens.length;
            lbImg.classList.remove('trocando', 'esq');
            document.querySelectorAll('.lb-mini').forEach((m, i) =>
                m.classList.toggle('ativa', i === atual)
            );
        }, 200);
    }

    function abrirLb(idx) {
        atual = idx;
        lbImg.src = imagens[atual].src;
        lbImg.alt = imagens[atual].alt;
        lbCont.textContent = (atual + 1) + ' / ' + imagens.length;
        buildMinis();
        lb.classList.add('aberto');
        document.body.style.overflow = 'hidden';
    }

    function fecharLb() {
        lb.classList.remove('aberto');
        zerarZoom();
        document.body.style.overflow = '';
    }

    function zerarZoom() {
        zoomed = false;
        lbImg.classList.remove('zoomed');
        lbWrap.classList.remove('zoomed');
    }

    // Clique na imagem principal = zoom 2.2×
    lbWrap.addEventListener('click', () => {
        zoomed = !zoomed;
        lbImg.classList.toggle('zoomed', zoomed);
        lbWrap.classList.toggle('zoomed', zoomed);
    });

    // Setas de navegação
    document.getElementById('lb-prev').addEventListener('click', () =>
        irPara((atual - 1 + imagens.length) % imagens.length, 'left')
    );
    document.getElementById('lb-next').addEventListener('click', () =>
        irPara((atual + 1) % imagens.length)
    );

    // Fechar pelo botão ou clicando fora
    document.getElementById('lb-fechar').addEventListener('click', fecharLb);
    lb.addEventListener('click', e => { if (e.target === lb) fecharLb(); });

    // Teclado: ESC fecha, setas navegam
    document.addEventListener('keydown', e => {
        if (!lb.classList.contains('aberto')) return;
        if (e.key === 'Escape')      fecharLb();
        if (e.key === 'ArrowRight')  irPara((atual + 1) % imagens.length);
        if (e.key === 'ArrowLeft')   irPara((atual - 1 + imagens.length) % imagens.length, 'left');
    });

    // Abre ao clicar em qualquer imagem do produto
    document.querySelectorAll('.imgProduto img').forEach((img, i) => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => abrirLb(i));
    });
})();


// ── Spotify ──

// Busca o token no Laravel (renovado automaticamente via cache)
async function getToken() {
    const res = await fetch('/spotify/token');
    const data = await res.json();
    return data.token;
}

// Busca álbum pelo nome + artista para maior precisão
async function buscarAlbum(nomeAlbum, nomeArtista) {
    const token = await getToken();
    const query = encodeURIComponent(`album:${nomeAlbum} artist:${nomeArtista}`);

    const res = await fetch(
        `https://api.spotify.com/v1/search?q=${query}&type=album&limit=1`,
        { headers: { Authorization: `Bearer ${token}` } }
    );

    const data = await res.json();
    return data.albums?.items[0] ?? null;
}

// Atualiza o iframe com o álbum encontrado
async function atualizarEmbed() {
    try {
        const el = document.getElementById('spotifyData');
        console.log('1. spotifyData encontrado:', el);
        console.log('2. album:', el?.dataset.album);
        console.log('3. artist:', el?.dataset.artist);

        const token = await getToken();
        console.log('4. token recebido:', token ? 'ok' : 'VAZIO');

        const resultado = await buscarAlbum(el.dataset.album, el.dataset.artist);
        console.log('5. resultado Spotify:', resultado);

        const iframe = document.getElementById('spotifyEmbed');
        const erro   = document.getElementById('spotifyErro');

        if (resultado) {
            iframe.src = `https://open.spotify.com/embed/album/${resultado.id}?utm_source=generator&theme=0`;
            iframe.style.display = 'block';
            console.log('6. iframe src setado:', iframe.src);
        } else {
            erro.style.display = 'block';
            console.log('6. album nao encontrado');
        }

    } catch(e) {
        console.error('ERRO no atualizarEmbed:', e);
    }
}

document.addEventListener('DOMContentLoaded', atualizarEmbed);