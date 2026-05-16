<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - {{ $product->name }} - {{ $product->artist }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="@vite('resources/css/telaDeCompra.css')">
    <link rel="shortcut icon" type="imagex/png" href="/src/assets/images/logoVinilDeRua.svg">

</head>



<body class="fundoPrincipal">

    <section class="telaCompra">

        @php
            $cover = $product->images->first();
            $secundarias = $product->images->skip(1);
        @endphp

        {{-- Coluna esquerda: imagens --}}
        <section class="detalhesProduto">
            <div class="nomeProduto">
                <h1>{{ $product->name }} - {{ $product->artist }}</h1>
            </div>
            <div class="imgProduto">

                {{-- Imagem principal (capa) --}}
                @if($cover)
                    <img src="{{ $cover->path }}" alt="Capa de {{ $product->name }}" id="imgPrincipal">
                @endif

                {{-- Miniaturas: apenas imagens secundárias (is_cover = false) --}}
                @if($secundarias->count() > 0)
                    <div class="imgProdutoMini">
                        @foreach($secundarias as $img)
                            <img src="{{ $img->path }}" alt="Imagem de {{ $product->name }}" class="cadaImgMini" style="cursor:pointer">
                        @endforeach
                    </div>
                @endif

            </div>



            <div class="descricaoProduto">
                <p>{{ $product->description }}</p>
            </div>

        </section>

        {{-- Coluna direita: infos + Spotify + compra --}}
        <section class="infosProduto">


            {{-- Player Spotify dinâmico --}}
            <div class="tracklist">
                <iframe id="spotifyEmbed" src="" width="400px" height="352" frameborder="0"
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"
                    style="border-radius:12px; display:none">
                </iframe>
                <p id="spotifyErro" class="spotifyErro" style="display:none">
                    Álbum não encontrado no Spotify :(
                </p>
            </div>

            {{-- Preço e botão de compra --}}
            <div class="finalizarCompra">
                <p>R$ {{ number_format($product->price, 2, ',', '.') }}</p>

                <form action="/cart/store/{{ $product->id }}" method="POST">
                    @csrf
                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                    </button>
                </form>
            </div>

        </section>

    </section>

    {{-- Dados do produto para o JS ler — sem hardcode --}}
    <div id="spotifyData" data-album="{{ $product->name }}" data-artist="{{ $product->artist }}" style="display:none">
    </div>

    <script>
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
    </script>

</body>

</html>