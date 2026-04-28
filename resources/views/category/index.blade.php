<a href="/category/create">Criar uma Categoria</a>
<table border="1">  
    <tr>
        <td>Id</td>
        <td>Name</td>
    </tr>
    @foreach($categories as $category)
    <tr>
        <td>{{$category->id}}</td>
        <td>{{$category->name}}</td>
    </tr>
    @endforeach
</table>