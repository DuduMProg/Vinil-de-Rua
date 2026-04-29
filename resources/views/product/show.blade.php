<h1>{{$product->name}}/{{$product->Category->name}}</h1>
@foreach($product->images as $img)
<div>
    <img src="{{$img->path}}">
</div>
@endforeach
<h2>R$ {{$product->price}}</h2>
<form action="/cart/store/{{$product->id}}" method="POST">
    @csrf
    <button type="submit">Comprar!</button>
</form>
