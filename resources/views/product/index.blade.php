<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Page</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    @vite('resources/css/styleAdm.css')
    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

</body>

</html>
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

            <button class="itemMenuAtivo" onclick="window.location.href='/product'">
                Todos os produtos
            </button>

            <button class="itemMenu" onclick="window.location.href='/dashboard'">
                Dashboard
            </button>

            <button class="itemMenu" onclick="window.location.href='/product/create'">
                Adicionar Produto
            </button>

            <button class="itemMenu" onclick="window.location.href='/product/remove'">
                Deletar Produto
            </button>

            <button class="itemMenu" onclick="window.location.href='/notifications'">
                Notificações
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

        </header>

        <a href="/product/create" class="btnNovoProduto">
            + Novo Produto
        </a>

        <a href="/tag/show/1">
            Pag de ofertas
        </a>

        <table border="1">

            <tr>
                <th>Id</th>
                <th>Capa</th>
                <th>Produto</th>
                <th>Artista</th>
                <th>Categoria</th>
                <th>Tag</th>
                <th>Estoque</th>
                <th>Preço</th>
                <th>Imagens</th>
                <th>Ações</th>
            </tr>

            @foreach($products as $p)

                @php
                    $cover = $p->images->firstWhere('is_cover', true)
                        ?? $p->images->first();
                @endphp

                <tr>

                    <td>{{ $p->id }}</td>

                    <td>
                        @if($cover)
                            <img src="{{ $cover->path }}" width="60" alt="Capa">
                        @else
                            —
                        @endif
                    </td>

                    <td>
                        <a href="/categories/{{ $p->category->id }}">
                            {{ $p->name }}
                        </a>
                    </td>

                    <td>{{ $p->artist }}</td>

                    <td>
                        {{ $p->category->name ?? 'Sem categoria' }}
                    </td>

                    <td>
                        @if($p->tag)
                            <span>{{ $p->tag->name }}</span>
                        @else
                            Sem tag
                        @endif
                    </td>

                    <td>{{ $p->stock }}</td>

                    <td>
                        R$ {{ number_format($p->price, 2, ',', '.') }}
                    </td>

                    <td>{{ $p->images_count }}</td>

                    <td>

                        <a href="/product/{{ $p->id }}/edit">
                            Editar
                        </a>

                        |

                        <form action="/product/{{ $p->id }}" method="POST" style="display:inline"
                            onsubmit="return confirm('Deletar {{ $p->name }}?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Deletar
                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

        </table>

    </main>

</div>