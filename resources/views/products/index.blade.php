<x-layout title="Shop">
    <section class="max-w-7xl mx-auto px-5 sm:px-8 py-12">
        <div class="mb-8">
            <span class="font-mono text-xs text-bunny-violet tracking-[0.3em]">SHOP</span>
            <h1 class="font-display font-extrabold text-3xl mt-2">Katalog Produk</h1>
        </div>

        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-full text-sm border {{ !request('type') && !request('category') ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Semua</a>
            <a href="{{ route('products.index', ['type' => 'merch']) }}" class="px-4 py-2 rounded-full text-sm border {{ request('type') === 'merch' ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Merchandise</a>
            <a href="{{ route('products.index', ['type' => 'album']) }}" class="px-4 py-2 rounded-full text-sm border {{ request('type') === 'album' ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Album</a>

            <form method="GET" class="ml-auto flex">
                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                    class="border border-bunny-line rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
            </form>
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-24 text-bunny-graphite">
                <p class="font-display text-lg">Belum ada produk ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </section>
</x-layout>
