<x-layout title="Magazine">
    <section class="max-w-7xl mx-auto px-5 sm:px-8 py-12">
        <div class="mb-8">
            <span class="font-mono text-xs text-bunny-violet tracking-[0.3em]">MAGAZINE</span>
            <h1 class="font-display font-extrabold text-3xl mt-2">Cerita & Update</h1>
        </div>

        <div class="flex flex-wrap gap-3 mb-10">
            <a href="{{ route('magazine.index') }}" class="px-4 py-2 rounded-full text-sm border {{ !request('category') ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Semua</a>
            <a href="{{ route('magazine.index', ['category' => 'interview']) }}" class="px-4 py-2 rounded-full text-sm border {{ request('category') === 'interview' ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Wawancara</a>
            <a href="{{ route('magazine.index', ['category' => 'behind-the-scenes']) }}" class="px-4 py-2 rounded-full text-sm border {{ request('category') === 'behind-the-scenes' ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Behind The Scenes</a>
            <a href="{{ route('magazine.index', ['category' => 'update']) }}" class="px-4 py-2 rounded-full text-sm border {{ request('category') === 'update' ? 'bg-bunny-ink text-white border-bunny-ink' : 'border-bunny-line hover:border-bunny-violet' }}">Update</a>
        </div>

        @if ($articles->isEmpty())
            <div class="text-center py-24 text-bunny-graphite">
                <p class="font-display text-lg">Belum ada artikel dipublikasikan.</p>
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($articles as $article)
                    <a href="{{ route('magazine.show', $article) }}" class="group block">
                        <div class="aspect-[4/3] rounded-2xl bg-bunny-mist border border-bunny-line overflow-hidden">
                            @if ($article->cover_image)
                                <img src="{{ asset('storage/'.$article->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $article->title }}">
                            @endif
                        </div>
                        <span class="font-mono text-[10px] text-bunny-violet tracking-widest mt-3 block">{{ strtoupper($article->categoryLabel()) }}</span>
                        <h3 class="font-display font-semibold mt-1 group-hover:text-bunny-violet transition-colors">{{ $article->title }}</h3>
                        <p class="text-sm text-bunny-graphite mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                        <p class="text-xs text-bunny-graphite mt-2">{{ $article->published_at?->translatedFormat('d M Y') }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">{{ $articles->links() }}</div>
        @endif
    </section>
</x-layout>
