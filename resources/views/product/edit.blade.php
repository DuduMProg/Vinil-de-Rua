<form action="/product/update/{{$product->id}}" method="POST">
    @csrf
    <div>
        Nome do Produto: <input type="text" name="name" value="{{$product->name}}">
    </div>
    <div>
        Descrição: <input type="text" name="description" value="{{$product->description}}>
    </div>
    <div>
        Imagem 1: <input type="text" name="image1" value="{{$product->image1}}>
    </div>
    <div>
        Imagem 2: <input type="text" name="image2" value="{{$product->image2}}>
    </div>
    <div>
        Imagem 3: <input type="text" name="image3" value="{{$product->image3}}>
    </div>
    <div>
        Preço: <input type="number" name="price" value="{{$product->price}}>
    </div>
    <button type="submit">Editar Produto</button>
</form>