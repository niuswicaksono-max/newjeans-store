<x-admin-layout title="Pesanan">
    <div class="flex flex-wrap gap-3 mb-6 items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 rounded-lg text-sm border {{ !request('status') ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line' }}">Semua</a>
            @foreach (['pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Batal'] as $key => $label)
                <a href="{{ route('admin.orders.index', ['status' => $key]) }}" class="px-3 py-1.5 rounded-lg text-sm border {{ request('status') === $key ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line' }}">{{ $label }}</a>
            @endforeach
        </div>
        <form method="GET">
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari no. pesanan..." class="border border-bunny-line rounded-lg px-4 py-2 text-sm">
        </form>
    </div>

    <div class="bg-white border border-bunny-line rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-bunny-mist text-left text-xs font-mono text-bunny-graphite">
                <tr>
                    <th class="px-5 py-3">No. Pesanan</th>
                    <th class="px-5 py-3">Pelanggan</th>
                    <th class="px-5 py-3">Total</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Tanggal</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t border-bunny-line">
                        <td class="px-5 py-3 font-mono">{{ $order->order_number }}</td>
                        <td class="px-5 py-3">{{ $order->user->name }}</td>
                        <td class="px-5 py-3 font-mono">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-1 rounded-full
                                @class([
                                    'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                                    'bg-blue-100 text-blue-700' => $order->status === 'processing',
                                    'bg-purple-100 text-purple-700' => $order->status === 'shipped',
                                    'bg-green-100 text-green-700' => $order->status === 'completed',
                                    'bg-red-100 text-red-700' => $order->status === 'cancelled',
                                ])">
                                {{ $order->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-bunny-violet hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-bunny-graphite">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</x-admin-layout>
