<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }}</title>
</head>
<link rel="stylesheet" href="{{ asset('css/category.css') }}">

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        scroll-behavior: smooth;
    }

    :root {
        /* fontes */
        --fontePrimaria: 'Caesar Dressing', cursive;
        --fonteSecundaria: 'Anton', sans-serif;
        --fonteTerciaria: "Young Serif", serif;
        /* Cores */
        --gradienteVertical1: linear-gradient(180deg, rgba(191, 191, 191, 1) 0%, rgba(81, 81, 81, 1) 100%);
        --gradienteVertical2: linear-gradient(180deg, rgba(81, 81, 81, 1) 0%, rgba(191, 191, 191, 1) 100%);
        --gradienteCardDiscos: linear-gradient(-41deg, rgba(159, 159, 159, 1) 0%, rgba(255, 255, 255, 1) 100%);
        /* drop shadow discos */
        --dropShadowDiscos: box-shadow: 0px 0px 6px 6px rgba(0, 0, 0, 0.404);
    }

    .catalogoCategoria {
        display: grid;
        grid-template-columns: repeat(4, 224px);
        gap: 150px;
        font-family: Arial, sans-serif;
        justify-content: center;
        padding: 125px 0;
        margin: 0 210px;
    }

    .cardDisco {
        width: 224px;
        height: 253px;
        background: var(--gradienteCardDiscos);
        font-family: var(--fontePrimaria);
        border-radius: 5px;
        padding: 0px 7px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .cardDisco:hover {
        transform: scale(1.03);
    }

    .cardDisco .imgCard {
        cursor: pointer;
        padding-top: 6px;
        padding-left: 7px;
        padding-right: 9px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cardDisco .imgCard>img {
        max-width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .infoDisco {
        font-size: 15px;
        padding-bottom: 20px;
    }

    .infoDisco .precoDisco {
        padding-top: 4px;
        font-weight: bold;
        font-size: 20px;
    }


    .preçoEFavDisco {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .preçoEFavDisco button {
        border-radius: 3px;
        border: 1px solid #000000;
        padding: 2px 12px;
        font-family: var(--fontePrimaria);
        cursor: pointer;
        transition: background-color 0.1s ease-in-out, transform 0.1s ease-in-out;
    }

    .preçoEFavDisco button:hover {
        background-color: #acacac;
        color: #ffffff;
        border: 2.2px solid #ffffff;
        transform: scale(1.0);
        box-shadow: 12px 12px 12px 2px rgba(0, 0, 0, 0.2);
    }

    .preçoEFavDisco .favorite img {
        width: 20px;
        height: 20px;
        transition: color 0.8s ease-in-out;
        cursor: pointer;
    }

    .preçoEFavDisco .cart img {
        width: 20px;
        height: 20px;
        transition: color 0.8s ease-in-out;
        cursor: pointer;
    }

    .preçoEFavDisco .favorite img:hover {
        content: url("https://i.ibb.co/b5vJrSGP/favorite-Red.png");
    }

    .preçoEFavDisco .cart img:hover {
        content: url("https://i.ibb.co/DPg9f9c3/add-shopping-cart-3.png");
    }
</style>

<body>

    {{-- resources/views/category/show.blade.php --}}

    <h1>{{ $category->name }}</h1>
    <p>{{ $products->count() }} disco(s) encontrado(s)</p>

    <div class="containerDiscos">
        @forelse($products as $p)

            @php
                $cover = $p->images->firstWhere('is_cover', true) ?? $p->images->first();
            @endphp

            <div class="cardDisco">

                @if($cover)
                    <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}" class="imgCard">
                @endif

                <div class="infoDisco">
                    <p class="nomeDisco">
                        {{ $p->name }} - {{ $p->artist }}
                    </p>

                    <p class="precoDisco">
                        R$ {{ number_format($p->price, 2, ',', '.') }}
                    </p>
                </div>

                <div class="preçoEFavDisco">

                    <button class="btnComprarAgora" onclick="window.location.href='{{ route('/product.show', $p->id) }}'">
                        {{ $p->stock > 0 ? 'Comprar agora' : 'Fora de estoque' }}
                    </button>

                    <div class="cart">
                        <form action="/cart/store/{{ $p->id }}" method="POST">
                            @csrf

                            <button type="submit" class="addCarrinho" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                            </button>
                        </form>
                    </div>

                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <p>Nenhum produto nessa categoria.</p>
        @endforelse
    </div>


</body>

</html>