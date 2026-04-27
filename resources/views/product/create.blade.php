<form action="/product/store" method="POST">
    @csrf

    <div>
        Nome do Produto: 
        <input type="text" name="name">
    </div>

    <div>
        Descrição: 
        <input type="text" name="description">
    </div>

    <div>
        Imagens (URLs):
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
        <input type="text" name="images[]" placeholder="https://...">
    </div>

    <div>
        Preço: 
        <input type="number" name="price" step="0.01">
    </div>

    <button type="submit">Criar Produto</button>
</form>