<x-admin-layout title="Magazine (CMS)">
    <div class="flex justify-between items-center mb-6">
        <form method="GET">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel..." class="border border-bunny-line rounded-lg px-4 py-2 text-sm">
        </form>
        <a href="{{ route('admin.articles.create') }}" class="bg-bunny-ink text-white font-semibold px-5 py-2 rounded-lg hover:bg-bunny-violet transition-colors text-sm">+ Tulis Artikel</a>
    </div>

    <div class="bg-white border border-bunny-line rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-bunny-mist text-left text-xs font-mono text-bunny-graphite">
                <tr>
                    <th class="px-5 py-3">Judul</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Penulis</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr class="border-t border-bunny-line">
                        <td class="px-5 py-3 font-medium">{{ $article->title }}</td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $article->categoryLabel() }}</td>
                        <td class="px-5 py-3 text-bunny-graphite">{{ $article->author->name }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $article->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $article->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-bunny-violet hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="inline" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-bunny-graphite">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $articles->links() }}</div>
</x-admin-layout>
