<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Vinil de Rua ADM</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    @vite('resources/css/styleAdm.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <div class="painelAdmin">

        <!-- MENU LATERAL -->
        <aside class="menuLateral">

            <div class="areaLogo">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                <h1>Vinil de Rua</h1>
            </div>

            <nav class="menuPrincipal">
                <button class="itemMenuAtivo" onclick="window.location.href='/admin/dashboard'">
                    Dashboard
                </button>

                <button class="itemMenu" onclick="window.location.href='/admin/product/create'">
                    Adicionar Produto
                </button>

                <button class="itemMenu" onclick="window.location.href='/admin/product'">
                    Todos os produtos
                </button>

                <button class="itemMenu" onclick="window.location.href='/admin/orders'">
                    Pedidos
                </button>
            </nav>

            <div class="menuCategorias">

                <h1>Categorias</h1>

                <ul>
                    @foreach($categories as $category)
                        <li>
                            <span>{{ $category->name }}</span>
                            <span>{{ $category->products_count }}</span>
                        </li>
                    @endforeach
                </ul>

            </div>

            <div class="menuLogout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="itemMenu">Sair</button>
                </form>
            </div>

        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudoPrincipal">

            <!-- MENU SUPERIOR -->
            <header class="menuSuperior">

                <div class="campoBusca">

                    <input type="text" placeholder="Buscar produto...">

                    <div class="btnBusca">
                        <button>Buscar</button>
                    </div>

                </div>

                <div class="areaUsuario">
                    <i class="icon-user" id="btnUsuario">
                        <img src="https://i.ibb.co/v6qZmTGv/perfil-Icon.png" alt="">
                    </i>

                    <div class="menuLogout" id="menuLogout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="itemMenu">Sair</button>
                        </form>
                    </div>
                </div>

            </header>

    <!-- CARDS DE RESUMO -->
    <div class="cardsResumo">
        
        <div class="cardResumo">
                    <p class="cardLabel">Total de Produtos</p>
                    <h2 class="cardValor">{{ $totalProducts }}</h2>
                </div>
                
                <div class="cardResumo">
                    <p class="cardLabel">Usuários Cadastrados</p>
                    <h2 class="cardValor">{{ $totalUsers }}</h2>
                </div>
                
                <div class="cardResumo">
                    <p class="cardLabel">Pedidos Pendentes</p>
                    <h2 class="cardValor">{{ $totalPendingOrders }}</h2>
                </div>
                
                <div class="cardResumo">
                    <p class="cardLabel">Receita Total</p>
                    <h2 class="cardValor">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</h2>
                </div>

            </div>
            
            <!-- GRÁFICOS -->
            <div class="areaGraficos">

                <!-- Pedidos por período -->
                <div class="grafico">
                    <h3>Pedidos por mês</h3>
                    <canvas id="graficoPedidos"></canvas>
                </div>

                <!-- Produtos mais vendidos -->
                <div class="grafico">
                    <h3>Produtos mais vendidos</h3>
                    <canvas id="graficoMaisVendidos"></canvas>
                </div>

                <!-- Usuários cadastrados por mês -->
                <div class="grafico">
                    <h3>Usuários cadastrados por mês</h3>
                    <canvas id="graficoUsuarios"></canvas>
                </div>

            </div>

            <!-- TABELA DE PEDIDOS RECENTES -->
            <div class="tabelaPedidos">
                <h3>Pedidos Recentes</h3>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td>{{ $order->payment_label }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($order->status === 'pending')
                                    <form action="/admin/orders/{{ $order->id }}/approve" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">Aprovar</button>
                                    </form>
                                    |
                                    <form action="/admin/orders/{{ $order->id }}/cancel" method="POST" style="display:inline"
                                        onsubmit="return confirm('Cancelar pedido #{{ $order->id }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">Cancelar</button>
                                    </form>
                                @else
                                    {{ $order->status_label }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Nenhum pedido ainda.</td>
                        </tr>
                    @endforelse
                </table>
            </div>

        </main>

    </div>

    <script>
        // ── Pedidos por período (últimos 6 meses) ──
        new Chart(document.getElementById('graficoPedidos'), {
            type: 'line',
            data: {
                labels: {!! json_encode($ordersByMonth->pluck('month')) !!},
                datasets: [{
                    label: 'Pedidos',
                    data: {!! json_encode($ordersByMonth->pluck('total')) !!},
                    borderColor: '#000',
                    backgroundColor: 'rgba(0,0,0,0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // ── Produtos mais vendidos (pizza) ──
        new Chart(document.getElementById('graficoMaisVendidos'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($topProducts->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($topProducts->pluck('total_vendido')) !!},
                    backgroundColor: [
                        '#1D1D1D',
                        '#3D3D3D',
                        '#5E5E5E',
                        '#7E7E7E',
                        '#9E9E9E',
                        '#BEBEBE',
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Produtos mais vendidos',
                    }
                }
            }
        });

        // ── Usuários por mês (linha empilhada) ──
        new Chart(document.getElementById('graficoUsuarios'), {
            type: 'line',
            data: {
                labels: {!! json_encode($usersByMonth->pluck('month')) !!},
                datasets: [{
                    label: 'Usuários',
                    data: {!! json_encode($usersByMonth->pluck('total')) !!},
                    backgroundColor: 'rgba(126, 126, 126, 0.4)',
                    borderColor: '#7E7E7E',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Usuários cadastrados por mês',
                    },
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>
    @vite('resources/js/loading.js')
    @vite('resources/js/admin.js')
</body>

</html>