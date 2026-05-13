<section class="telaCompra">

    @php
        $cover = $product->images->firstWhere('is_cover', true) ?? $product->images->first();
    @endphp

    <section class="detalhesProduto">

        <div class="imgProduto">

            @if($cover)
                <img src="{{ $cover->path }}" alt="Capa de {{ $product->name }}">
            @endif

        </div>

    </section>

    <section class="infosProduto">

        <div class="nomeProduto">
            <h1>
                {{ $product->name }} - {{ $product->artist }}
            </h1>
        </div>

        <div class="tracklist">


            <!-- <div class="tracklist">

                <iframe style="border-radius:12px" src="{{ $product->spotify_embed ?? '' }}" width="400px"
                    height="500px" frameBorder="2"
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy">
                </iframe>

            </div> -->

            @if($product->spotify_embed)
                <iframe style="border-radius:12px" src="{{ $product->spotify_embed }}" width="400px" height="500px"
                    frameBorder="2" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                    loading="lazy">
                </iframe>
            @endif

        </div>

        <div class="finalizarCompra">

            <p>
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </p>

            <form action="/cart/store/{{ $product->id }}" method="POST">
                @csrf

                <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    {{ $product->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                </button>
            </form>

        </div>

    </section>

</section>