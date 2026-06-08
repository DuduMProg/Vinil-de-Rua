@if($favorites->isEmpty())
    <div class="semFavoritos">
        <p>Você ainda não tem favoritos.</p>
        <a href="/product">Ver produtos</a>
    </div>
@else
    @foreach($favorites as $fav)
        @php
            $p = $fav->product;
            $cover = $p->images->first();
        @endphp

        <div class="favoritoItem">

            @if($cover)
                <img src="{{ $cover->path }}" alt="{{ $p->name }}" class="imgFav">
            @endif

            <div class="infoFav">
                <p>{{ $p->name }}</p>
                <p>{{ $p->artist }}</p>
                <p class="precoFav">
                    @if($p->tem_desconto)
                        <s style="color:#999; font-size:14px">
                            R$ {{ number_format($p->price, 2, ',', '.') }}
                        </s>
                        R$ {{ number_format($p->preco_com_desconto, 2, ',', '.') }}
                    @else
                        R$ {{ number_format($p->price, 2, ',', '.') }}
                    @endif
                </p>
            </div>

            <div class="acoessFav">

                {{-- Ver produto --}}
                <a href="/product/{{ $p->id }}" class="btnVerProduto">
                    Ver produto
                </a>
                <div class="wishlistCart">

                    {{-- Desfavoritar --}}
                    <form action="/whishlist/delete/{{ $p->id }}" method="POST" class="formDesfav">
                        @csrf
                        <button type="submit" class="btnDesfavoritar">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="desfavoritar"
                                onmouseover="this.src='https://i.ibb.co/9HR1wYgm/desfavoritar.png'"
                                onmouseout="this.src='https://i.ibb.co/5mHR0sq/favorite-Black.png'">
                        </button>
                    </form>

                    <form action="/cart/store/{{ $p->id }}" method="POST">
                        @csrf
                        <button type="submit" {{ $p->stock <= 0 ? 'disabled' : '' }} class="btnAdicionarCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
@endif