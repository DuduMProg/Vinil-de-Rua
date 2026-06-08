<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da compra - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    @vite('resources/css/resumoCompra.css')
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo-Vinil-De-Rua">
            </a>
            <p>VINIL <br>DE RUA</p>
        </div>

        <nav>
            <a href="/#catalogo">Catalogo</a>
            <a href="/tag/show/1">Ofertas</a>
            <a href="#contato">Contato</a>
        </nav>

        <div class="mobileMenuBtn" id="btnMenu">
            ☰
        </div>

        <div class="icons">
            <img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite" id="btnFavorite" style="cursor:pointer">

            <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png" alt="shopping-cart" id="btnCart"
                style="cursor:pointer">

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="/admin/dashboard">
                        <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                    </a>
                @else
                    <a href="/profile">
                        <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                    </a>
                @endif
            @else
                <a href="/login">
                    <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                </a>
            @endauth
        </div>

        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 id="sidebar-title">Carrinho</h2>
                <button id="btnFecharSidebar">✖</button>
            </div>

            <div class="sidebar-content" id="sidebar-content">
                {{-- preenchido via AJAX pelo JS --}}
            </div>

            <div class="btnResumo">
                <a href="/checkout">
                    <button>Resumo da compra</button>
                </a>
            </div>
        </div>

        {{-- Sidebar Favoritos --}}
        <div class="sidebar" id="sidebarFavorite">
            <div class="sidebar-header">
                <h2>Favoritos</h2>
                <button id="btnFecharFavorite">✖</button>
            </div>

            <div class="sidebar-content" id="favorite-content">
                {{-- preenchido via AJAX --}}
            </div>
        </div>
    </header>
    <div class="mobileNav" id="mobileNav">
        <a href="/#catalogo">Catálogo</a>
        <a href="/tag/show/1">Ofertas</a>
        <a href="#contato">Contato</a>
    </div>

    <section class="fundoPrincipal">

        {{-- Indicador de progresso --}}
        <div class="infoSituation">
            <div class="produtoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="">
                <p>Produtos</p>
            </div>
            <div class="indentificacaoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="">
                <p>Identificação</p>
            </div>
            <div class="pagamentoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="">
                <p>Pagamento</p>
            </div>
        </div>

        <section class="resumoCompra">

            <div class="txtResumo">
                <h1>Resumo da compra:</h1>
            </div>

            <section class="cardsInfos">

                {{-- Contato --}}
                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Contato:</h1>
                        <a href="/profile/edit">Editar</a>
                    </div>
                    <p>{{ $user->email }}</p>
                </div>

                {{-- Endereço --}}
                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Endereço:</h1>
                        <a href="/profile/edit">Editar</a>
                    </div>
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->endereco ?? '—' }}</p>
                    <p>{{ $user->cep ?? '—' }}</p>
                    <p>{{ $user->complemento ?? '—' }}</p>
                    <p>{{ $user->cidade ?? '—' }}, {{ $user->estado ?? '—' }} - BR</p>
                    <p>{{ $user->telefone ?? '—' }}</p>
                </div>

            </section>

            {{-- Itens do pedido --}}
            <div class="pedidoFinal">
                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Seu pedido</h1>
                        <a href="#" id="btnEditarPedido">Editar</a>
                    </div>

                    <div class="produtosFinais">
                        @foreach($cart->items as $i)
                            @php
                                $cover = $i->product->images->first();
                                $preco = $i->product->preco_com_desconto;
                            @endphp
                            <div class="produtoItem">
                                @if($cover)
                                    <img src="{{ $cover->path }}" alt="{{ $i->product->name }}">
                                @endif
                                <div class="infosFinais">
                                    <h1>{{ $i->product->name }} - {{ $i->product->artist }}</h1>
                                    <p>R$ {{ number_format($preco, 2, ',', '.') }}</p>
                                    <p class="qntProdutoFinal">Quantidade: {{ $i->units }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="infosPessoaisCompra">
                        <p>Produtos: {{ $cart->items->sum('units') }}</p>
                        <p>Total: R$ {{ number_format($total, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Formas de pagamento --}}
            <form action="/checkout" method="POST" id="formCheckout">
                @csrf

                <div class="fazerPagamento">
                    <div class="formasPagamento">
                        <h1>Selecione uma forma de pagamento:</h1>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payment_method" value="pix" id="checkPix">
                                <span></span>
                                <img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay">
                                <p>PIX</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payment_method" value="credit_card" id="checkCartao">
                                <span></span>
                                <img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="mastercard-Pay">
                                <p>Débito/Crédito</p>
                            </label>
                        </div>

                    </div>

                    @if($errors->any())
                        <p style="color:red">{{ $errors->first() }}</p>
                    @endif

                    <button type="submit">Realizar o Pagamento</button>
                </div>

                {{-- Área PIX --}}
                <div id="areaPix" style="display:none; text-align:center;">
                    <h3>PIX</h3>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=Vinil%20De%20Rua%20Pagamento"
                        alt="QR Code PIX" class="qrPix">
                    <p class="chavePix">Chave PIX: contato@vinilderua.com.br</p>
                </div>

                {{-- Área Cartão --}}
                <div id="areaCartao" style="display:none;">
                    <div class="field-container">
                        <label for="name">Nome no cartão</label>
                        <input id="name" maxlength="20" type="text" value="{{ $user->name }}">
                    </div>
                    <div class="field-container">
                        <label for="cardnumber">Número do cartão</label>
                        <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
                    </div>
                    <div class="field-container">
                        <label for="expirationdate">Vencimento (mm/aa)</label>
                        <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
                    </div>
                    <div class="field-container">
                        <label for="securitycode">CVV</label>
                        <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
                    </div>
                </div>

            </form>

        </section>

        <footer id="contato">
            <div class="footerLogo">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">
                <h1>VINIL <br>DE RUA</h1>
            </div>
            <div class="avisosFooter">
                <p>Duvidas? (11) 4002-8922 (SP)</p>
                <p>Seg a Sex, 9h às 21h Sáb 10h às 18h</p>
            </div>
            <div class="termos">
                <a href="">Termos e Condições</a>
            </div>
        </footer>

    </section>

    @vite('resources/js/navbar.js')
    @vite('resources/js/loading.js')

    <script>
        // Mostra/esconde área de pagamento conforme seleção
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                document.getElementById('areaPix').style.display = 'none';
                document.getElementById('areaCartao').style.display = 'none';

                if (this.value === 'pix') {
                    document.getElementById('areaPix').style.display = 'block';
                }
            });
        });
    </script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js'></script>

</body>

</html>