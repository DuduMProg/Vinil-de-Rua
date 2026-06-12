{{-- resources/views/product/create.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Page</title>

    <!-- FONTES -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite('resources/css/styleAdm.css')
    <link rel="shortcut icon" type="imagex/png" href="https://i.ibb.co/kstCS19B/Icon-Logo.png">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

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
                        <li><a href="/admin/tag" class="linkMenuCat">Ver todas</a></li>
                        <li><a href="/admin/tag/create" class="linkMenuCat ativo">+ Nova tag</a></li>
                    </ul>
                </div>
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

            <!-- SEÇÃO -->
            <section class="secaoProdutos">

                <h1 class="tituloSecao">
                    Adicione o seu produto!
                </h1>

                @if($errors->any())
                    <ul style="color:red">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="formsEAddFoto">

                    {{-- FORM PRINCIPAL --}}
                    <div class="formsNovoProduto">

                        <form action="/admin/product" method="POST">
                            @csrf

                            <div class="infoForms">
                                <label>Nome do produto:</label>

                                <input type="text" name="name" placeholder="Nome do album..." value="{{ old('name') }}">
                            </div>

                            <div class="infoForms">
                                <label>Nome do(a) artista:</label>

                                <input type="text" name="artist" placeholder="Nome do artista..."
                                    value="{{ old('artist') }}">
                            </div>

                            <div class="infoForms">
                                <label>Descrição:</label>

                                <textarea type="text" name="description" placeholder="Descrição..."
                                    value="{{ old('description') }}" class="campoDescricao">
                                </textarea>
                            </div>

                            <div class="infoForms">
                                <label>Categoria:</label>

                                <select name="category_id">

                                    <option value="">
                                        Sem categoria
                                    </option>

                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="infoForms">
                                <label>Tag:</label>

                                <select name="tag_id">

                                    <option value="">
                                        Sem tag
                                    </option>

                                    @foreach($tags as $t)
                                        <option value="{{ $t->id }}" {{ old('tag_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="infoForms">
                                <label>Preço:</label>

                                <input type="number" name="price" step="0.01" placeholder="Preço..."
                                    value="{{ old('price') }}">
                            </div>

                            <div class="infoForms">
                                <label>Estoque:</label>

                                <input type="number" name="stock" placeholder="Estoque..."
                                    value="{{ old('stock', 0) }}">
                            </div>

                    </div>

                    {{-- IMAGENS --}}
                    <div class="addFoto">

                        <div class="infoForms">

                            <label>Imagem principal</label>

                            <input type="text" name="main_img" placeholder="https://...">

                        </div>

                        <div class="infoForms">

                            <label>Imagem secundária</label>

                            <input type="text" name="images[]" placeholder="https://...">

                        </div>

                        <div class="infoForms">

                            <label>Imagem secundária</label>

                            <input type="text" name="images[]" placeholder="https://...">

                        </div>

                        <div class="infoForms">

                            <label>Imagem secundária</label>

                            <input type="text" name="images[]" placeholder="https://...">

                        </div>

                        <div class="btnAdicionarP">

                            <button type="submit">
                                Adicionar produto
                            </button>

                        </div>

                        </form>

                    </div>

                </div>

            </section>

        </main>
    </div>
    @vite('resources/js/loading.js')
    @vite('resources/js/admin.js')

</body>

</html>