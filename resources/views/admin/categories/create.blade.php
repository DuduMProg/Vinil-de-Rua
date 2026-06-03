<form action="/category" method="POST">
    @csrf

    Nome: <input type="text" name="name">

    Banner (URL): <input type="text" name="banner" placeholder="https://...">

    <button type="submit">Criar</button>
</form>