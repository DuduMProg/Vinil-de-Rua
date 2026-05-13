<a href="/tag/create">Criar um tag</a>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nome</th>
    </tr>

    @foreach($tags as $t)
        <tr>
            <td>{{$t->id}}</td>
            <td>{{$t->name}}</td>
        </tr>
    @endforeach
</table>