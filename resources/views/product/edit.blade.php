<form action="/product/update/{{$product->id}}" method="POST">
    @csrf

    <div>
        Nome do Produto:
        <input type="text" name="name" value="{{$product->name}}">
    </div>

    <div>
        Nome do Artista:
        <input type="text" name="name" value="{{$product->artist}}">
    </div>

    <div>
        Descrição:
        <input type="text" name="description" value="{{$product->description}}">
    </div>

    <div>
        Categoria:
        <select name="category_id[]" multiple>
            @foreach(\App\Models\Category::all() as $c)
                <option value="{{$c->id}}">{{$c->name  ? 'selected' : '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        Tag: 
        <select name="tags_id[]" multiple>
            @foreach(\App\Models\Tag::all() as $t)
                <option value="{{$t->id}}">{{$t->name  ? 'selected' : '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        Preço:
        <input type="number" name="price" value="{{$product->price}}" step="0.01">
    </div>

    <div>
        Estoque:
        <input type="number" name="stock" value="{{ $product->stock }}">
    </div>

    <div>
        <p>Imagem Principal (Capa):</p>
        @php $cover = $product->images->firstWhere('is_cover', true) ?? $product->images->first() @endphp

        @if($cover)
            <img src="{{ $cover->path }}" width="150" alt="Capa atual">
            <p>{{ $cover->path }}</p>
        @endif
        <input type="text" name="main_img" placeholder="Nova capa https://...">
    </div>

    <div>
        <p>Imagens Secundárias:</p>
        @foreach($product->images->where('is_cover', false) as $img)
            <div>
                <img src="{{ $img->path }}" width="100">
                <p>{{ $img->path }}</p>
                <input type="text" name="images[]" placeholder="https://...">
            </div>
        @endforeach


    </div>




    <button type="submit">Editar Produto</button>
</form>