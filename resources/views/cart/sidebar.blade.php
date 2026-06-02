@if($cart->items->isEmpty())
    <p>Seu carrinho está vazio.</p>
    <div class="verMaisCart">
        <a href="/product">Se pudermos fazer algumas sugestões...</a>
    </div>
@else
    @php $total = 0; @endphp

    @foreach($cart->items as $i)
        @php
            $produto   = $i->product;
            $preco     = $produto->preco_com_desconto; // já aplica 15% se tiver tag oferta
            $subtotal  = $i->units * $preco;
            $total    += $subtotal;
            $cover     = $produto->images->first();
        @endphp

        <div class="produtoItem">
            @if($cover)
                <img src="{{ $cover->path }}" alt="{{ $produto->name }}" class="imgProdCart">
            @endif
            
            <div class="nomeProd">
                <p>{{ $produto->name }}</p>
                <div class="qntdProd">
                    <form action="/cart/decrement/{{ $i->product_id }}" method="POST">
                        @csrf
                        <button type="submit">-</button>
                    </form>

                    <span>{{ $i->units }}</span>

                    <form action="/cart/store/{{ $i->product_id }}" method="POST">
                        @csrf
                        <button type="submit">+</button>
                    </form>
                </div>
            </div>

            <div class="deletePrice">
                <form action="/cart/delete/{{ $i->product_id }}" method="POST">
                    @csrf
                    <button type="submit" class="deleteBtn">
                        <img src="https://i.ibb.co/Zzdfgwmf/delete.png" class="deleteIcon" alt="deletar">
                    </button>
                </form>

                {{-- Exibe preço com ou sem desconto --}}
                @if($produto->tem_desconto)
                    <p class="precoOriginal"><s>R$ {{ number_format($produto->price, 2, ',', '.') }}</s></p>
                    <p class="precoOferta">R$ {{ number_format($preco, 2, ',', '.') }}</p>
                @else
                    <p>R$ {{ number_format($preco, 2, ',', '.') }}</p>
                @endif

            </div>
        </div>
    @endforeach

    <div class="cartTotal">
        <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>
    </div>
@endif