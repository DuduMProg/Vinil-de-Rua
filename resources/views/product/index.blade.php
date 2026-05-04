{{-- resources/views/product/index.blade.php --}}

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="/product/create">+ Novo Produto</a>

<table border="1">
    <tr>
        <th>Id</th>
        <th>Capa</th>
        <th>Produto</th>
        <th>Artista</th>
        <th>Categoria</th>
        <th>Tag</th>
        <th>Estoque</th>
        <th>Preço</th>
        <th>Imagens</th>
        <th>Ações</th>
    </tr>

    @foreach($products as $p)
        @php $cover = $p->images->firstWhere('D', true) ?? $p->images->first() @endphp
        <tr>
            <td>{{ $p->id }}</td>
            <td>
                @if($cover)
                    <img src="{{ $cover->path }}" width="60" alt="Capa">
                @else
                    —
                @endif
            </td>
            <td><a href="/product/{{ $p->id }}">{{ $p->name }}</a></td>
            <td>{{ $p->artist }}</td>
            <td>{{ $p->category->name ?? 'Sem categoria' }}</td>
            <td>{{ $p->tag ?? 'Sem tag' }}</td>
            <td>{{ $p->stock }}</td>
            <td>R$ {{ number_format($p->price, 2, ',', '.') }}</td>
            <td>{{ $p->images_count }}</td>
            <td>
                <a href="/product/{{ $p->id }}/edit">Editar</a> |

                {{-- ✅ Delete via form com método DELETE --}}
                <form action="/product/{{ $p->id }}" method="POST" style="display:inline"
                    onsubmit="return confirm('Deletar {{ $p->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Deletar</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>