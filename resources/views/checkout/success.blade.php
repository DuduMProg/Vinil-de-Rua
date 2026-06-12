<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado — Vinil de Rua</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&family=Anton&family=Young+Serif&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
    @vite('resources/css/resumoCompra.css')
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <section class="checkoutCompra">



        <main class="successMain">

            {{-- Topo: ícone + título --}}
            <div class="successHeader">
                <div class="checkCircle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h1 class="successTitulo">Pedido #{{ $order->id }} confirmado!</h1>
                <p class="successSub">
                    Você receberá um e-mail com os detalhes em breve.
                </p>
            </div>

            {{-- Cards de resumo --}}
            <div class="successResumo">
                <div class="successMetrica">
                    <span>Total pago</span>
                    <strong>R$ {{ number_format($order->total, 2, ',', '.') }}</strong>
                </div>
                <div class="successMetrica">
                    <span>Pagamento</span>
                    <strong>{{ $order->payment_label }}</strong>
                </div>
                <div class="successMetrica">
                    <span>Data do pedido</span>
                    <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                </div>
                <div class="successMetrica">
                    <span>Situação</span>
                    <strong class="status-{{ $order->status }}">{{ $order->status_label }}</strong>
                </div>
            </div>

            {{-- Aviso de status --}}
            <div class="successAviso">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <p>Seu pedido está sendo processado. Assim que aprovado você receberá uma confirmação.</p>
            </div>

            {{-- Itens do pedido --}}
            <div class="successProdutos">
                <h2 class="successProdutosTitulo">Itens do pedido</h2>

                @foreach($order->items as $item)
                    @php $cover = $item->product->images->first(); @endphp
                    <div class="successItem">
                        @if($cover)
                            <img src="{{ $cover->path }}" alt="{{ $item->product->name }}" class="successItemImg">
                        @else
                            <div class="successItemImgPlaceholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                        @endif
                        <div class="successItemInfo">
                            <p class="successItemNome">{{ $item->product->name }}</p>
                            <p class="successItemArtista">{{ $item->product->artist }} · {{ $item->units }}x</p>
                        </div>
                        <span class="successItemPreco">
                            R$ {{ number_format($item->price * $item->units, 2, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Botões de ação --}}
            <div class="successAcoes">
                <a href="{{ route('profile.orders') }}" class="successBtn successBtnPrimary">
                    Ver meus pedidos
                </a>
                <a href="/" class="successBtn successBtnSecondary">
                    Continuar comprando →
                </a>
            </div>

        </main>

    </section>

    @vite('resources/js/loading.js')

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

</body>

</html>