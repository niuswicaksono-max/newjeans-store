<x-layout :title="$product->name">
    <section class="max-w-7xl mx-auto px-5 sm:px-8 py-12">
        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <div class="aspect-square rounded-3xl bg-bunny-mist border border-bunny-line overflow-hidden">
                    @if ($product->thumbnail)
                        <img id="main-product-image" src="{{ asset('storage/'.$product->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-display text-6xl text-bunny-line">NJ</div>
                    @endif
                </div>
                @if ($product->images->isNotEmpty())
                    <div class="grid grid-cols-4 gap-3 mt-3">
                        @if ($product->thumbnail)
                            <button type="button"
                                class="gallery-thumb aspect-square rounded-xl bg-bunny-mist border-2 border-bunny-violet overflow-hidden"
                                data-src="{{ asset('storage/'.$product->thumbnail) }}">
                                <img src="{{ asset('storage/'.$product->thumbnail) }}" class="w-full h-full object-cover">
                            </button>
                        @endif
                        @foreach ($product->images as $img)
                            <button type="button"
                                class="gallery-thumb aspect-square rounded-xl bg-bunny-mist border-2 border-transparent overflow-hidden"
                                data-src="{{ asset('storage/'.$img->path) }}">
                                <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <span class="font-mono text-xs text-bunny-violet tracking-widest">{{ strtoupper($product->category->name ?? '') }}</span>
                <h1 class="font-display font-extrabold text-3xl mt-2">{{ $product->name }}</h1>
                <p class="font-mono text-2xl mt-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                <p class="text-bunny-graphite mt-6 leading-relaxed">{{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}</p>

                <div class="mt-6 text-sm">
                    @if ($product->inStock())
                        <span class="text-green-600 font-medium">Stok tersedia ({{ $product->stock }})</span>
                    @else
                        <span class="text-red-500 font-medium">Stok habis</span>
                    @endif
                </div>

                <div class="flex gap-3 mt-8">
                    @auth
                        <form method="POST" action="{{ route('cart.store', $product) }}" class="flex-1">
                            @csrf
                            <button type="submit" @disabled(!$product->inStock())
                                class="w-full bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                                {{ $product->inStock() ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('wishlist.store', $product) }}">
                            @csrf
                            <button type="submit" class="border border-bunny-line px-5 rounded-full hover:border-bunny-violet hover:text-bunny-violet transition-colors h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 text-center bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors">Masuk untuk Membeli</a>
                    @endauth
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-20">
                <h2 class="font-display font-bold text-xl mb-6">Produk Lainnya</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach ($related as $r)
                        <x-product-card :product="$r" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImage = document.getElementById('main-product-image');
            const thumbs = document.querySelectorAll('.gallery-thumb');

            thumbs.forEach(function (thumb) {
                thumb.addEventListener('click', function () {
                    if (!mainImage) return;
                    mainImage.src = thumb.dataset.src;

                    thumbs.forEach(function (t) {
                        t.classList.remove('border-bunny-violet');
                        t.classList.add('border-transparent');
                    });
                    thumb.classList.remove('border-transparent');
                    thumb.classList.add('border-bunny-violet');
                });
            });
        });
    </script>
</x-layout>