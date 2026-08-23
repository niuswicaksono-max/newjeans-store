<x-layout title="Detail Pesanan">
    <section class="max-w-3xl mx-auto px-5 sm:px-8 py-12">
        <a href="{{ route('orders.index') }}" class="text-sm text-bunny-graphite hover:text-bunny-violet">← Kembali ke Pesanan</a>

        <div class="flex items-center justify-between mt-4 mb-8">
            <div>
                <h1 class="font-display font-extrabold text-2xl">{{ $order->order_number }}</h1>
                <p class="text-sm text-bunny-graphite mt-1">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full
                @class([
                    'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                    'bg-blue-100 text-blue-700' => $order->status === 'processing',
                    'bg-purple-100 text-purple-700' => $order->status === 'shipped',
                    'bg-green-100 text-green-700' => $order->status === 'completed',
                    'bg-red-100 text-red-700' => $order->status === 'cancelled',
                ])">
                {{ $order->statusLabel() }}
            </span>
        </div>

        @if ($order->tracking_number)
            <div class="bg-bunny-lilac/20 border border-bunny-violet/30 rounded-2xl p-4 mb-6 text-sm">
                <span class="font-mono text-bunny-graphite">NO. RESI:</span> <span class="font-mono font-semibold">{{ $order->tracking_number }}</span>
            </div>
        @endif

        <div class="bg-white border border-bunny-line rounded-2xl p-6 space-y-4 mb-6">
            <h2 class="font-display font-semibold">Item Pesanan</h2>
            @foreach ($order->items as $item)
                <div class="flex justify-between text-sm border-b border-bunny-line last:border-0 pb-3 last:pb-0">
                    <span>{{ $item->product_name }} <span class="text-bunny-graphite">×{{ $item->quantity }}</span></span>
                    <span class="font-mono">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="flex justify-between font-display font-bold pt-2 border-t border-bunny-line">
                <span>Total</span>
                <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white border border-bunny-line rounded-2xl p-6 text-sm space-y-2">
            <h2 class="font-display font-semibold mb-2">Alamat Pengiriman</h2>
            <p>{{ $order->recipient_name }} — {{ $order->phone }}</p>
            <p class="text-bunny-graphite">{{ $order->shipping_address }}</p>
            @if ($order->notes)
                <p class="text-bunny-graphite italic mt-2">Catatan: {{ $order->notes }}</p>
            @endif
        </div>
    </section>
</x-layout>
