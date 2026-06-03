<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedido Confirmado - Vinil de Rua</title>
    @vite('resources/css/resumoCompra.css')
</head>
<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/"><img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo"></a>
            <p>VINIL <br>DE RUA</p>
        </div>
    </header>

    <section class="fundoPrincipal" style="padding: 150px 50px; text-align:center">

        <h1 style="font-family: var(--fontePrimaria); font-size: 40px">
            Pedido #{{ $order->id }} confirmado!
        </h1>

        <p style="margin-top: 20px; font-family: var(--fonteTerciaria)">
            Forma de pagamento: {{ $order->payment_label }}
        </p>

        <p style="margin-top: 10px; font-family: var(--fonteTerciaria)">
            Total: R$ {{ number_format($order->total, 2, ',', '.') }}
        </p>

        <div style="margin-top: 40px">
            @foreach($order->items as $item)
                @php $cover = $item->product->images->first(); @endphp
                <div style="display:flex; align-items:center; gap:20px; justify-content:center; margin-bottom:20px">
                    @if($cover)
                        <img src="{{ $cover->path }}" width="80" alt="{{ $item->product->name }}">
                    @endif
                    <div>
                        <p>{{ $item->product->name }} - {{ $item->product->artist }}</p>
                        <p>{{ $item->units }}x R$ {{ number_format($item->price, 2, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="/product" style="margin-top:40px; display:inline-block; font-family: var(--fontePrimaria)">
            Continuar comprando →
        </a>

    </section>

    @vite('resources/js/loading.js')

</body>
</html>