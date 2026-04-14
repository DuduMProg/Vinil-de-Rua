<form action="/product/store" method="POST">
    @csrf
    <div>
        Nome do Produto: <input type="text" name="name">
    </div>
    <div>
        Descrição: <input type="text" name="description">
    </div>
    <div>
        Imagem 1: <input type="text" name="image1">
    </div>
    <div>
        Imagem 2: <input type="text" name="image2">
    </div>
    <div>
        Imagem 3: <input type="text" name="image3">
    </div>
    <div>
        Preço: <input type="number" name="price">
    </div>
    <button type="submit">Criar Produto</button>
</form>