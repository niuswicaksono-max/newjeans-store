<x-admin-layout title="Produk">
    @unless ($hasCategories)
        <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl px-4 py-3 mb-6">
            <span class="text-lg leading-none">⚠️</span>
            <div>
                <p class="font-semibold">Belum ada kategori.</p>
                <p class="mt-0.5">Tambah produk butuh kategori dulu. <a href="{{ route('admin.categories.index') }}" class="underline font-semibold hover:text-amber-900">Buat kategori di sini</a>.</p>
            </div>
        </div>
    @endunless

    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 mb-6">
        <form method="GET" class="relative sm:w-72">
            <span class="absolute inset-y-0 left-3 flex items-center text-bunny-graphite/60">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                class="w-full border border-bunny-line rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition">
        </form>
        <a href="{{ route('admin.products.create') }}" class="bg-bunny-ink text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-bunny-violet transition-colors text-sm text-center whitespace-nowrap">+ Tambah Produk</a>
    </div>

    <div class="bg-white border border-bunny-line rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-bunny-mist text-left text-xs font-mono text-bunny-graphite">
                <tr>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Harga</th>
                    <th class="px-5 py-3">Stok</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t border-bunny-line hover:bg-bunny-mist/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/'.$product->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover border border-bunny-line shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-bunny-mist border border-bunny-line shrink-0 flex items-center justify-center text-bunny-graphite/40 text-xs">—</div>
                                @endif
                                <span class="font-medium">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-5 py-3 font-mono">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 font-mono {{ $product->stock <= 5 ? 'text-red-500' : '' }}">{{ $product->stock }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right space-x-3 whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-bunny-violet hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-bunny-graphite">
                            <p class="mb-3">Belum ada produk.</p>
                            <a href="{{ route('admin.products.create') }}" class="inline-block bg-bunny-ink text-white font-semibold px-5 py-2 rounded-lg hover:bg-bunny-violet transition-colors text-sm">+ Tambah Produk Pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-admin-layout>
