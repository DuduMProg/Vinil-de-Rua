{{-- resources/views/product/create.blade.php --}}

<h1>Novo Produto</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/product" method="POST">
    @csrf

    <div>
        Nome do Álbum:
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        Artista:
        <input type="text" name="artist" value="{{ old('artist') }}">
    </div>

    <div>
        Descrição:
        <input type="text" name="description" value="{{ old('description') }}">
    </div>

    <div>
        Categoria:
        <select name="category_id">
            <option value="">Sem categoria</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        Tag:
        <select name="tag_id">
            <option value="">Sem tag</option>
            @foreach($tags as $t)
                <option value="{{ $t->id }}" {{ old('tag_id') == $t->id ? 'selected' : '' }}>
                    {{ $t->name }}
                </option>
            @endforeach
        </select>

    <div>
        Preço:
        <input type="number" name="price" step="0.01" value="{{ old('price') }}">
    </div>

    <div>
        Estoque:
        <input type="number" name="stock" value="{{ old('stock', 0) }}">
    </div>

    <div>
        Imagem Principal (URL):
        <input type="text" name="main_img" placeholder="https://...">
    </div>

    <div>
        Imagens Secundárias (URLs):
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
    </div>

    <button type="submit">Criar Produto</button>
</form>