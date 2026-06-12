<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tag - ADM</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    @vite('resources/css/styleAdm.css')
</head>

<body>

    <div class="painelAdmin">

        <!-- MENU LATERAL -->
        <aside class="menuLateral">
            <div class="areaLogo">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                <h1>Vinil de Rua</h1>
            </div>

            <nav class="menuPrincipal">
                <button class="itemMenu" onclick="window.location.href='/admin/dashboard'">Dashboard</button>
                <button class="itemMenu" onclick="window.location.href='/admin/product/create'">Adicionar
                    Produto</button>
                <button class="itemMenu" onclick="window.location.href='/admin/product'">Todos os produtos</button>
                <button class="itemMenu" onclick="window.location.href='/admin/orders'">Pedidos</button>
            </nav>

            <div class="menuCategorias">
                <h1>Categorias</h1>
                <ul>
                    <li>
                        <a href="/admin/category" class="linkMenuCat">Ver todas</a>
                    </li>
                    <li>
                        <a href="/admin/category/create" class="linkMenuCat">+ Nova categoria</a>
                    </li>
                </ul>

                <div class="menuTagsLink">
                    <h1>Tags</h1>
                    <ul>
                        <li><a href="/admin/tag" class="linkMenuCat ativo">Ver todas</a></li>
                        <li><a href="/admin/tag/create" class="linkMenuCat">+ Nova tag</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudoPrincipal">

            <header class="menuSuperior">
                <div class="campoBusca">
                    <input type="text" placeholder="Buscar tag...">
                    <div class="btnBusca"><button>Buscar</button></div>
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

            <section class="secaoProdutos">

                <div class="tituloEAcao">
                    <h1 class="tituloSecao">Editar Tag</h1>
                </div>

                @if($errors->any())
                    <ul class="listaErros">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="formsNovoProduto">
                    <form action="{{ route('admin.tag.update', $tag->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="infoForms">

                            <div class="formsEAddFoto">
                                <label for="name">Nome da tag</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                            </div>

                        </div>

                        <div class="btnAdicionarP">
                            <button type="submit">Salvar Alterações</button>
                        </div>

                    </form>
                </div>

            </section>
        </main>
    </div>

    @vite('resources/js/loading.js')
    @vite('resources/js/admin.js')
</body>

</html>