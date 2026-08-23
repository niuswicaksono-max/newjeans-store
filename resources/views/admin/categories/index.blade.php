<x-admin-layout title="Kategori">
    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2 bg-white border border-bunny-line rounded-2xl overflow-hidden h-fit">
            <table class="w-full text-sm">
                <thead class="bg-bunny-mist text-left text-xs font-mono text-bunny-graphite">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Tipe</th>
                        <th class="px-5 py-3">Jumlah Produk</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-bunny-line">
                            <td class="px-5 py-3">
                                <input type="text" name="name" form="cat-form-{{ $category->id }}" value="{{ $category->name }}" class="border border-transparent hover:border-bunny-line rounded-lg px-2 py-1 w-full bg-transparent focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
                            </td>
                            <td class="px-5 py-3">
                                <select name="type" form="cat-form-{{ $category->id }}" class="border border-transparent hover:border-bunny-line rounded-lg px-2 py-1 bg-transparent focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                                    <option value="merch" @selected($category->type === 'merch')>Merch</option>
                                    <option value="album" @selected($category->type === 'album')>Album</option>
                                </select>
                            </td>
                            <td class="px-5 py-3 text-bunny-graphite">{{ $category->products_count }}</td>
                            <td class="px-5 py-3 text-right space-x-3">
                                <form id="cat-form-{{ $category->id }}" method="POST" action="{{ route('admin.categories.update', $category) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <button type="submit" form="cat-form-{{ $category->id }}" class="text-bunny-violet hover:underline">Simpan</button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-bunny-graphite">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white border border-bunny-line rounded-2xl p-6 h-fit">
            <h2 class="font-display font-semibold mb-4">Tambah Kategori</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-mono tracking-widest text-bunny-graphite">NAMA</label>
                    <input type="text" name="name" required class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                </div>
                <div>
                    <label class="text-xs font-mono tracking-widest text-bunny-graphite">TIPE</label>
                    <select name="type" required class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                        <option value="merch">Merch</option>
                        <option value="album">Album</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors">Tambah</button>
            </form>
        </div>
    </div>
</x-admin-layout>
