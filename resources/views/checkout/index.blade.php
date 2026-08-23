<x-layout title="Checkout">
    <section class="max-w-5xl mx-auto px-5 sm:px-8 py-12">
        <h1 class="font-display font-extrabold text-3xl mb-8">Checkout</h1>

        <div class="grid md:grid-cols-3 gap-10">
            <form method="POST" action="{{ route('checkout.store') }}" class="md:col-span-2 space-y-5">
                @csrf
                <div class="bg-white border border-bunny-line rounded-2xl p-6 space-y-5">
                    <h2 class="font-display font-semibold text-lg">Alamat Pengiriman</h2>
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">NAMA PENERIMA</label>
                        <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" required
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
                    </div>
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">NO. TELEPON</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
                    </div>
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">ALAMAT LENGKAP</label>
                        <textarea name="shipping_address" rows="3" required
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">{{ old('shipping_address') }}</textarea>
                    </div>
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">CATATAN (OPSIONAL)</label>
                        <textarea name="notes" rows="2"
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors">Buat Pesanan</button>
                <p class="text-xs text-bunny-graphite text-center">Pembayaran akan dikonfirmasi manual oleh admin setelah pesanan dibuat.</p>
            </form>

            <div class="bg-bunny-mist border border-bunny-line rounded-2xl p-6 h-fit">
                <h2 class="font-display font-semibold text-lg mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3">
                    @foreach ($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->product->name }} <span class="text-bunny-graphite">×{{ $item->quantity }}</span></span>
                            <span class="font-mono">Rp{{ number_format($item->subtotal(), 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-bunny-line mt-4 pt-4 flex justify-between font-display font-bold">
                    <span>Total</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </section>
</x-layout>
