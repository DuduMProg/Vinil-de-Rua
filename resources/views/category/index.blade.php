<a href="/category/create">Criar uma Categoria</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <td>Id</td>
        <td>Banner</td>
        <td>Name</td>
        <td>Produtos</td>
        <td>Ações</td>
    </tr>
    @foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>
            @if($category->banner)
                <img src="{{ asset('storage/' . $category->banner) }}" width="80" alt="banner">
            @else
                —
            @endif
        </td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->products_count }}</td>
        <td>
            <a href="/category/{{ $category->id }}/edit">Editar</a> |
            <form action="/category/{{ $category->id }}" method="POST" style="display:inline"
                  onsubmit="return confirm('Deletar {{ $category->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit">Deletar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>