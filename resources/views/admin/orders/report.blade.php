<x-admin-layout title="Laporan Penjualan">
    <form method="GET" class="flex gap-3 mb-6 items-end">
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite block mb-1">BULAN</label>
            <select name="month" class="border border-bunny-line rounded-lg px-4 py-2 text-sm">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" @selected($month == $m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite block mb-1">TAHUN</label>
            <input type="number" name="year" value="{{ $year }}" class="border border-bunny-line rounded-lg px-4 py-2 text-sm w-28">
        </div>
        <button type="submit" class="bg-bunny-ink text-white font-semibold px-5 py-2 rounded-lg hover:bg-bunny-violet transition-colors text-sm">Tampilkan</button>
    </form>

    <div class="grid grid-cols-2 gap-5 mb-8">
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">TOTAL PENDAPATAN</p>
            <p class="font-display font-bold text-2xl mt-1">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white border border-bunny-line rounded-2xl p-5">
            <p class="text-xs text-bunny-graphite font-mono">JUMLAH PESANAN (LUNAS/DIPROSES)</p>
            <p class="font-display font-bold text-2xl mt-1">{{ $totalOrders }}</p>
        </div>
    </div>

    <div class="bg-white border border-bunny-line rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-bunny-mist text-left text-xs font-mono text-bunny-graphite">
                <tr>
                    <th class="px-5 py-3">No. Pesanan</th>
                    <th class="px-5 py-3">Tanggal</th>
                    <th class="px-5 py-3">Item</th>
                    <th class="px-5 py-3">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t border-bunny-line">
                        <td class="px-5 py-3 font-mono">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $order->items->count() }} item</td>
                        <td class="px-5 py-3 font-mono">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-bunny-graphite">Tidak ada transaksi pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
