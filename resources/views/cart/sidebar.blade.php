{{-- resources/views/cart/sidebar.blade.php --}}
{{-- Apenas o conteúdo interno da sidebar — sem o wrapper externo --}}

@if($cart->items->isEmpty())
    <p>Seu carrinho está vazio.</p>
    <a href="/product">Se pudermos fazer algumas sugestões...</a>
@else

    @php $total = 0; @endphp

    @foreach($cart->items as $i)
        @php
            $subtotal = $i->units * $i->product->price;
            $total   += $subtotal;
            $cover    = $i->product->images->firstWhere('is_cover', true)
                     ?? $i->product->images->first();
        @endphp

        <div class="produtoItem">
            @if($cover)
                <img src="{{ $cover->path }}" alt="{{ $i->product->name }}" class="imgProdCart">
            @endif

            <div class="nomeProd">
                <p>{{ $i->product->name }}</p>
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

                <p>R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
            </div>
        </div>
    @endforeach

    <div class="cartTotal">
        <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>
    </div>

@endif