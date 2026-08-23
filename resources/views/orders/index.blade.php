<x-layout title="Pesanan Saya">
    <section class="max-w-5xl mx-auto px-5 sm:px-8 py-12">
        <h1 class="font-display font-extrabold text-3xl mb-8">Pesanan Saya</h1>

        @if ($orders->isEmpty())
            <div class="text-center py-24 text-bunny-graphite">
                <p class="font-display text-lg mb-4">Belum ada pesanan.</p>
                <a href="{{ route('products.index') }}" class="text-bunny-violet font-semibold hover:underline">Mulai belanja →</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order) }}" class="block bg-white border border-bunny-line rounded-2xl p-5 hover:border-bunny-violet transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-mono text-sm text-bunny-graphite">{{ $order->order_number }}</p>
                                <p class="text-xs text-bunny-graphite mt-1">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
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
                                <p class="font-mono font-semibold mt-2">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $orders->links() }}</div>
        @endif
    </section>
</x-layout>
