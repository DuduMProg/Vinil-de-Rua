<form action="/category/{{ $category->id }}" method="POST">
    @csrf
    @method('PUT')

    Nome: <input type="text" name="name" value="{{ old('name', $category->name) }}">

    <div>
        Banner atual:
        @if($category->banner)
            <img src="{{ $category->banner }}" width="300" alt="Banner atual">
        @else
            <p>Nenhum banner cadastrado.</p>
        @endif
    </div>

    Novo Banner (URL): <input type="text" name="banner" placeholder="https://..." value="{{ old('banner', $category->banner) }}">

    <button type="submit">Salvar Alterações</button>
</form>