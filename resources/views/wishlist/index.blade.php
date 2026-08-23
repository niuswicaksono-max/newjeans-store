<x-layout title="Wishlist">
    <section class="max-w-7xl mx-auto px-5 sm:px-8 py-12">
        <h1 class="font-display font-extrabold text-3xl mb-8">Wishlist</h1>

        @if ($wishlists->isEmpty())
            <div class="text-center py-24 text-bunny-graphite">
                <p class="font-display text-lg mb-4">Belum ada produk di wishlist.</p>
                <a href="{{ route('products.index') }}" class="text-bunny-violet font-semibold hover:underline">Jelajahi produk →</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($wishlists as $wishlist)
                    <div class="relative">
                        <x-product-card :product="$wishlist->product" />
                        <form method="POST" action="{{ route('wishlist.destroy', $wishlist) }}" class="absolute top-3 right-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-white border border-bunny-line flex items-center justify-center hover:border-red-400 hover:text-red-500 transition-colors" title="Hapus dari wishlist">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
