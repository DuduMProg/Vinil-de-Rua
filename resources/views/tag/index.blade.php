<a href="/tag/create">Criar um tag</a>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>

    @foreach($tags as $t)
        <tr>
            <td>{{$t->id}}</td>
            <td>{{$t->name}}</td>
            <td>
                <a href="/tag/{{ $t->id }}/edit">Editar</a> |

                <form action="/tag/{{ $t->id }}" method="POST" style="display:inline"
                    onsubmit="return confirm('Deletar {{ $t->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Deletar</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>