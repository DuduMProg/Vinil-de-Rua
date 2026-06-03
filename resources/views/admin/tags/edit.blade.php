<form action="/tag/{{ $tag->id }}" method="POST">
    @csrf
    @method('PUT')

    Nome: <input type="text" name="name" value="{{ old('name', $tag->name) }}">

    <button type="submit">Salvar Alterações</button>
</form>