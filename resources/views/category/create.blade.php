<form action="/category/store" method="POST">
    @csrf
    Nome: <input type="text" name="name">
    <button type="submit">Criar</button>
</form>