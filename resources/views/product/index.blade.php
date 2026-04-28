<a href="/product/create">Criar Produto</a>

<table border="1">
    <tr>
        <th>Id do produto</th>
        <th>Produto</th>
        <th>Descrição</th>
        <th>Categoria</th>
        <th>Imagens</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>
    @foreach($products as $p)
        <tr>
            <td>{{$p->id}}</td>
            <td>{{$p->name}}</td>
            <td>{{$p->description}}</td>
            <td>{{$p->category->name ?? 'Sem categoria' }}</td>
            <td>{{$p->images->count()}}</td>
            <td>{{$p->price}}</td>
            <td>
                <a href="/product/edit/{{$p->id}}">Editar</a> |
                <a href="/product/delete/{{$p->id}}">Deletar</a>
            </td>
        </tr>
    @endforeach
</table>