<form action="/product/update/{{$product->id}}" method="POST">
    @csrf

    <div>
        Nome do Produto: 
        <input type="text" name="name" value="{{$product->name}}">
    </div>

    <div>
        Descrição: 
        <input type="text" name="description" value="{{$product->description}}">
    </div>

    <div>
        Preço: 
        <input type="number" name="price" value="{{$product->price}}" step="0.01">
    </div>

    <div>
        <p>Imagens atuais:</p>
        @foreach($product->images as $img)
            <div>
                <img src="{{$img->path}}" width="100">
                <p>{{$img->path}}</p>
            </div>
        @endforeach
    </div>

    <div>
        Adicionar novas imagens (URLs):
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
    </div>

    <button type="submit">Editar Produto</button>
</form>