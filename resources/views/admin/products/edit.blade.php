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
                    Editar Produto
                </h1>

                @if($errors->any())
                    <ul class="listaErros">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="formsEAddFoto">

                    <div class="formsNovoProduto">


                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT'


                            <div class="infoForms">
                                <label>Nome do produto:</label>
                                <input type="text" name="name" value="{{ $product->name }}">
                            </div>

                            <div class="infoForms">
                                <label>Nome do artista:</label>
                                <input type="text" name="artist" value="{{ $product->artist }}">
                            </div>

                            <div class="infoForms">
                                <label>Descrição:</label>
                                <textarea name="description"
                                    class="campoDescricao">{{ $product->description }}</textarea>
                            </div>

                            <div class="infoForms">
                                <label>Categoria:</label>

                                <select name="category_id">
                                    <option value="">Sem categoria</option>

                                    @foreach(\App\Models\Category::all() as $c)
                                        <option value="{{ $c->id }}" {{ $product->category_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="infoForms">
                                <label>Tag:</label>

                                <select name="tag_id">
                                    <option value="">Sem tag</option>

                                    @foreach(\App\Models\Tag::all() as $t)
                                        <option value="{{ $t->id }}" {{ $product->tag_id == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="infoForms">
                                <label>Preço:</label>
                                <input type="number" name="price" value="{{ $product->price }}" step="0.01">
                            </div>

                            <div class="infoForms">
                                <label>Estoque:</label>
                                <input type="number" name="stock" value="{{ $product->stock }}">
                            </div>

                    </div>

                    <div class="addFoto">

                        @php
                            $cover = $product->images->firstWhere('is_cover', true)
                                ?? $product->images->first();
                        @endphp

                        <div class="previewImagem">

                            <h3>Capa Atual</h3>

                            @if($cover)
                                <img src="{{ $cover->path }}" alt="Capa do produto">

                                <p>{{ $cover->path }}</p>
                            @endif

                        </div>

                        <div class="infoForms">
                            <label>Nova imagem principal</label>
                            <input type="text" name="main_img" placeholder="https://...">
                            <h3>Imagens Secundárias</h3>
                        </div>

                        <div class="previewSecundarias">


                            @foreach($product->images->where('is_cover', false) as $img)

                                <div class="imagemSecundaria">

                                    <img src="{{ $img->path }}" alt="Imagem">

                                    <p>{{ $img->path }}</p>

                                </div>

                            @endforeach

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
                                Salvar Alterações
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