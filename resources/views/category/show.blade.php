{{-- resources/views/category/show.blade.php --}}

<h1>{{ $category->name }}</h1>
<p>{{ $products->count() }} disco(s) encontrado(s)</p>

<div>
    @forelse($products as $p)
        @php $cover = $p->images->firstWhere('is_cover', true) ?? $p->images->first() @endphp

        <div>
            @if($cover)
                <img src="{{ $cover->path }}" width="150" alt="Capa de {{ $p->name }}">
            @endif

            <p><a href="/product/{{ $p->id }}">{{ $p->name }}</a> — {{ $p->artist }}</p>
            <p>Categoria: {{ $p->category->name ?? 'Sem categoria' }}</p>
            <p>{{ $p->description }}</p>
            <h3>R$ {{ number_format($p->price, 2, ',', '.') }}</h3>

            @if($p->images->count() > 1)
                <div>
                    @foreach($p->images->where('is_cover', false) as $img)
                        <img src="{{ $img->path }}">
                    @endforeach
                </div>
            @endif

            <form action="/cart/store/{{ $p->id }}" method="POST">
                @csrf
                <button type="submit" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                    {{ $p->stock > 0 ? 'Comprar!' : 'Fora de estoque' }}
                </button>
            </form>
        </div>

    @empty
        <p>Nenhum produto nessa categoria.</p>
    @endforelse
</div>