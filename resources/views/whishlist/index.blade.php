{{-- resources/views/favorite/index.blade.php --}}

<h1>Meus Favoritos</h1>

@if($favorites->isEmpty())
    <p>Você ainda não tem favoritos.</p>
    <a href="/product">Ver produtos</a>
@else
    <div>
        @foreach($favorites as $fav)
            @php
                $p = $fav->product;
                $cover = $p->images->firstWhere('is_cover', true) ?? $p->images->first();
            @endphp

            <div class="cardDisco">
                @if($cover)
                    <img src="{{ $cover->path }}" alt="Capa de {{ $p->name }}" class="imgCard">
                @endif

                <div class="infoDisco">
                    <p class="nomeDisco">
                        <a href="/product/{{ $p->id }}">{{ $p->name }}</a>
                    </p>
                    <p>{{ $p->artist }}</p>
                    <p class="precoDisco">
                        R$ {{ number_format($p->price, 2, ',', '.') }}
                    </p>
                </div>

                <div style="display:flex; gap:8px; margin-top:8px">
                    {{-- Adicionar ao carrinho --}}
                    <form action="/cart/store/{{ $p->id }}" method="POST">
                        @csrf
                        <button type="submit" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </form>

                    {{-- Remover dos favoritos --}}
                    <form action="/favorite/delete/{{ $p->id }}" method="POST">
                        @csrf
                        <button type="submit">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="remover favorito">
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif