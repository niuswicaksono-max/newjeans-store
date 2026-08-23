@props(['product'])

<a href="{{ route('products.show', $product) }}" class="group block">
    <div class="aspect-square rounded-2xl bg-bunny-mist border border-bunny-line overflow-hidden relative">
        @if ($product->thumbnail)
            <img src="{{ asset('storage/'.$product->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
        @else
            <div class="w-full h-full flex items-center justify-center font-display text-3xl text-bunny-line">NJ</div>
        @endif

        @if (!$product->inStock())
            <span class="absolute top-3 left-3 bg-bunny-ink text-white text-[10px] font-mono px-2 py-1 rounded-full">SOLD OUT</span>
        @endif
    </div>
    <div class="mt-3">
        <span class="font-mono text-[10px] text-bunny-graphite tracking-widest">{{ strtoupper($product->category->name ?? '') }}</span>
        <h3 class="font-display font-semibold text-sm mt-1 group-hover:text-bunny-violet transition-colors">{{ $product->name }}</h3>
        <p class="font-mono text-sm mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
    </div>
</a>
