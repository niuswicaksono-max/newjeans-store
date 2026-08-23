<x-layout :title="$article->title">
    <article class="max-w-3xl mx-auto px-5 sm:px-8 py-12">
        <a href="{{ route('magazine.index') }}" class="text-sm text-bunny-graphite hover:text-bunny-violet">← Kembali ke Magazine</a>

        <span class="font-mono text-xs text-bunny-violet tracking-[0.3em] block mt-6">{{ strtoupper($article->categoryLabel()) }}</span>
        <h1 class="font-display font-extrabold text-3xl md:text-4xl mt-3 leading-tight">{{ $article->title }}</h1>
        <p class="text-sm text-bunny-graphite mt-4">Oleh {{ $article->author->name }} · {{ $article->published_at?->translatedFormat('d M Y') }}</p>

        @if ($article->cover_image)
            <div class="aspect-[16/9] rounded-2xl bg-bunny-mist border border-bunny-line overflow-hidden mt-8">
                <img src="{{ asset('storage/'.$article->cover_image) }}" class="w-full h-full object-cover" alt="{{ $article->title }}">
            </div>
        @endif

        <div class="prose prose-neutral max-w-none mt-10 leading-relaxed">
            {!! nl2br(e($article->content)) !!}
        </div>
    </article>

    @if ($more->isNotEmpty())
        <section class="bg-white border-t border-bunny-line mt-16">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
                <h2 class="font-display font-bold text-xl mb-6">Baca Juga</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($more as $item)
                        <a href="{{ route('magazine.show', $item) }}" class="group block">
                            <div class="aspect-[4/3] rounded-2xl bg-bunny-mist border border-bunny-line overflow-hidden">
                                @if ($item->cover_image)
                                    <img src="{{ asset('storage/'.$item->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </div>
                            <h3 class="font-display font-semibold mt-3 group-hover:text-bunny-violet transition-colors">{{ $item->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layout>
