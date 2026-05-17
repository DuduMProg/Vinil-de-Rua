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
    const el = document.getElementById('spotifyData');
    const album = el.dataset.album;
    const artist = el.dataset.artist;
    const iframe = document.getElementById('spotifyEmbed');
    const erro = document.getElementById('spotifyErro');

    const resultado = await buscarAlbum(album, artist);

    if (resultado) {
        iframe.src = `https://open.spotify.com/embed/album/${resultado.id}?utm_source=generator&theme=0`;
        iframe.style.display = 'block';
    } else {
        erro.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', atualizarEmbed);