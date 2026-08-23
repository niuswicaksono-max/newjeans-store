<x-admin-layout title="Dashboard">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-10">
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">TOTAL PRODUK</p>
            <p class="font-display font-bold text-2xl mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">TOTAL PESANAN</p>
            <p class="font-display font-bold text-2xl mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">PESANAN PENDING</p>
            <p class="font-display font-bold text-2xl mt-1 text-yellow-600">{{ $pendingOrders }}</p>
        </div>
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">PENDAPATAN BULAN INI</p>
            <p class="font-display font-bold text-2xl mt-1">Rp{{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white border border-bunny-line rounded-2xl p-6">
            <h2 class="font-display font-semibold mb-4">Pesanan Terbaru</h2>
            @forelse ($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex justify-between items-center py-2 border-b border-bunny-line last:border-0 text-sm hover:text-bunny-violet">
                    <span class="font-mono">{{ $order->order_number }}</span>
                    <span>{{ $order->user->name }}</span>
                    <span class="font-mono">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </a>
            @empty
                <p class="text-sm text-bunny-graphite">Belum ada pesanan.</p>
            @endforelse
        </div>

        <div class="bg-white border border-bunny-line rounded-2xl p-6">
            <h2 class="font-display font-semibold mb-4">Stok Menipis (≤5)</h2>
            @forelse ($lowStockProducts as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="flex justify-between items-center py-2 border-b border-bunny-line last:border-0 text-sm hover:text-bunny-violet">
                    <span>{{ $product->name }}</span>
                    <span class="font-mono text-red-500">{{ $product->stock }} tersisa</span>
                </a>
            @empty
                <p class="text-sm text-bunny-graphite">Stok semua produk aman.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('admin.orders.report') }}" class="inline-block mt-6 text-sm font-semibold text-bunny-violet hover:underline">Lihat Laporan Penjualan Bulanan →</a>
</x-admin-layout>
