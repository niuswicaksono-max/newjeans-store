<x-layout title="Keranjang">
    <section class="max-w-5xl mx-auto px-5 sm:px-8 py-12">
        <h1 class="font-display font-extrabold text-3xl mb-8">Keranjang Belanja</h1>

        @if ($cartItems->isEmpty())
            <div class="text-center py-24 text-bunny-graphite">
                <p class="font-display text-lg mb-4">Keranjangmu masih kosong.</p>
                <a href="{{ route('products.index') }}" class="text-bunny-violet font-semibold hover:underline">Mulai belanja →</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($cartItems as $item)
                    <div class="flex items-center gap-5 bg-white border border-bunny-line rounded-2xl p-4">
                        <div class="w-20 h-20 rounded-xl bg-bunny-mist border border-bunny-line overflow-hidden shrink-0">
                            @if ($item->product->thumbnail)
                                <img src="{{ asset('storage/'.$item->product->thumbnail) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-display font-semibold">{{ $item->product->name }}</h3>
                            <p class="font-mono text-sm text-bunny-graphite mt-1">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                        </div>
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                class="w-16 border border-bunny-line rounded-lg px-2 py-1 text-sm text-center">
                            <button type="submit" class="text-xs font-semibold text-bunny-violet hover:underline">Update</button>
                        </form>
                        <p class="font-mono font-semibold w-28 text-right">Rp{{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 bg-bunny-mist border border-bunny-line rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm text-bunny-graphite">Total Belanja</p>
                    <p class="font-display font-bold text-2xl">Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('checkout.index') }}" class="bg-bunny-ink text-white font-semibold px-8 py-3 rounded-full hover:bg-bunny-violet transition-colors">Checkout</a>
            </div>
        @endif
    </section>
</x-layout>
