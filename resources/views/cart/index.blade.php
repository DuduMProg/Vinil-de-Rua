{{-- resources/views/cart/index.blade.php --}}

@php $total = 0; @endphp


@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

@if($cart->items->isEmpty())
    <p>Seu carrinho está vazio.</p>
    <a href="/product">Ver produtos</a>
@else
    <table border="1">
        <tr>
            <th>Capa</th>
            <th>Produto</th>
            <th>Artista</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>

        @foreach($cart->items as $i)
            @php
                $subtotal = $i->units * $i->product->price;
                $total += $subtotal;
                $cover = $i->product->images->firstWhere('is_cover', true) ?? $i->product->images->first();
            @endphp
            <tr>
                <td>
                    @if($cover)
                        <img src="{{ $cover->path }}" width="60" alt="Capa">
                    @else
                        —
                    @endif
                </td>
                <td><a href="/product/{{ $i->product->id }}">{{ $i->product->name }}</a></td>
                <td>{{ $i->product->artist }}</td>
                <td>
                    {{-- Decrementa --}}
                    <form action="/cart/decrement/{{ $i->product_id }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit">−</button>
                    </form>

                    {{ $i->units }}

                    {{-- Incrementa --}}
                    <form action="/cart/store/{{ $i->product_id }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit">+</button>
                    </form>
                </td>
                <td>R$ {{ number_format($i->units * $i->product->price, 2, ',', '.') }}</td>
                <td>
                    <form action="/cart/delete/{{ $i->product_id }}" method="POST" style="display:inline"
                        onsubmit="return confirm('Remover {{ $i->product->name }}?')">
                        @csrf
                        <button type="submit">Remover</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <p><strong>Total: R$ {{ number_format($total, 2, ',', '.') }}</strong></p>

    <a href="/checkout">Finalizar Pedido →</a>
@endif