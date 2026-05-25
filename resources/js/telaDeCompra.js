document.querySelectorAll('.imgProduto img').forEach(img => {
    img.addEventListener('click', function () {
        // Cria o overlay
        const overlay = document.createElement('div');
        overlay.className = 'img-overlay';
        overlay.innerHTML = `<img src="${this.src}" alt="${this.alt}">`;
        document.body.appendChild(overlay);

        overlay.addEventListener('click', function () {
            overlay.remove();
        });
    });
});


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