{{-- resources/views/product/show.blade.php --}}

@php $cover = $product->images->firstWhere('is_cover', true) ?? $product->images->first() @endphp

@if($cover)
    <img src="{{ $cover->path }}" alt="Capa de {{ $product->name }}" width="300">
@endif

<h1>{{ $product->name }} — <span>{{ $product->artist }}</span></h1>

{{-- Categoria clicável que leva para a listagem da categoria --}}
<p>
    Categoria: 
    @if($product->category)
        <a href="/categories/{{ $product->category->id }}">{{ $product->category->name }}</a>
    @else
        Sem categoria
    @endif
</p>

<p>{{ $product->description }}</p>
<h3>R$ {{ number_format($product->price, 2, ',', '.') }}</h3>

@if($product->images->count() > 1)
    <div>
        @foreach($product->images->where('is_cover', false) as $img)
            <img src="{{ $img->path }}">
        @endforeach
    </div>
@endif

<form action="/cart/store/{{ $product->id }}" method="POST">
    @csrf
    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>
        {{ $product->stock > 0 ? 'Comprar!' : 'Fora de estoque' }}
    </button>
</form>