<x-admin-layout title="Detail Pesanan">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-bunny-graphite hover:text-bunny-violet">← Kembali ke Pesanan</a>

    <div class="grid md:grid-cols-3 gap-8 mt-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white border border-bunny-line rounded-2xl p-6">
                <h2 class="font-display font-semibold mb-4">{{ $order->order_number }}</h2>
                @foreach ($order->items as $item)
                    <div class="flex justify-between text-sm border-b border-bunny-line last:border-0 py-2">
                        <span>{{ $item->product_name }} ×{{ $item->quantity }}</span>
                        <span class="font-mono">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="flex justify-between font-display font-bold pt-3 border-t border-bunny-line mt-2">
                    <span>Total</span>
                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white border border-bunny-line rounded-2xl p-6 text-sm space-y-1">
                <h2 class="font-display font-semibold mb-2">Pelanggan & Pengiriman</h2>
                <p>{{ $order->user->name }} ({{ $order->user->email }})</p>
                <p>{{ $order->recipient_name }} — {{ $order->phone }}</p>
                <p class="text-bunny-graphite">{{ $order->shipping_address }}</p>
                @if ($order->notes)
                    <p class="text-bunny-graphite italic">Catatan: {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <div class="bg-white border border-bunny-line rounded-2xl p-6 h-fit">
            <h2 class="font-display font-semibold mb-4">Update Status</h2>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-xs font-mono tracking-widest text-bunny-graphite">STATUS</label>
                    <select name="status" class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                        @foreach (['pending' => 'Menunggu Konfirmasi', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-mono tracking-widest text-bunny-graphite">NO. RESI</label>
                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                </div>
                <button type="submit" class="w-full bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors">Simpan</button>
            </form>
        </div>
    </div>
</x-admin-layout>
