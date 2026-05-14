<form action="/tag/{{ $tag->id }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        Nome da Tag:
        <input type="text" name="name" value="{{ $tag->name }}">
    </div>

    <button type="submit">Editar Tag</button>
</form>