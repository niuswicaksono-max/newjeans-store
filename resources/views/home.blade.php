<x-layout title="Home">
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-bunny-line">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-20 md:py-28 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="font-mono text-xs tracking-[0.3em] text-bunny-violet">BUNNIES CLUB STORE</span>
                <h1 class="font-display font-extrabold text-4xl md:text-6xl leading-[1.05] mt-4">
                    GET READY<br>WITH <span class="text-bunny-violet">NEWJEANS</span>
                </h1>
                <p class="text-bunny-graphite mt-6 max-w-md">Merchandise resmi, album fisik & digital, sampai konten eksklusif dari Minji, Hanni, Haerin, Danielle, dan Hyein — semua di satu tempat.</p>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('products.index') }}" class="bg-bunny-ink text-white font-semibold px-6 py-3 rounded-full hover:bg-bunny-violet transition-colors text-sm">Belanja Sekarang</a>
                    <a href="{{ route('magazine.index') }}" class="border border-bunny-line px-6 py-3 rounded-full hover:border-bunny-violet hover:text-bunny-violet transition-colors text-sm font-semibold">Baca Magazine</a>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-bunny-lilac/50 via-bunny-mist to-white border border-bunny-line perforated overflow-hidden">
                    <img src="{{ asset('images/hero.jpg') }}" alt="NewJeans" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white border border-bunny-line rounded-2xl px-5 py-3 shadow-sm font-mono text-xs">
                    ✦ NEW DROP MONTHLY
                </div>
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    <section class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="font-mono text-xs text-bunny-violet tracking-widest">01 / SHOP</span>
                <h2 class="font-display font-bold text-2xl md:text-3xl mt-1">Produk Terbaru</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-bunny-violet hover:underline">Lihat Semua →</a>
        </div>

        @if ($featuredProducts->isEmpty())
            <p class="text-bunny-graphite text-sm">Belum ada produk. Admin bisa menambahkannya lewat panel admin.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>

    {{-- Magazine teaser --}}
    <section class="bg-white border-y border-bunny-line">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="font-mono text-xs text-bunny-violet tracking-widest">02 / MAGAZINE</span>
                    <h2 class="font-display font-bold text-2xl md:text-3xl mt-1">Cerita Terbaru</h2>
                </div>
                <a href="{{ route('magazine.index') }}" class="text-sm font-semibold text-bunny-violet hover:underline">Lihat Semua →</a>
            </div>

            @if ($latestArticles->isEmpty())
                <p class="text-bunny-graphite text-sm">Belum ada artikel dipublikasikan.</p>
            @else
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($latestArticles as $article)
                        <a href="{{ route('magazine.show', $article) }}" class="group block">
                            <div class="aspect-[4/3] rounded-2xl bg-bunny-mist border border-bunny-line overflow-hidden">
                                @if ($article->cover_image)
                                    <img src="{{ asset('storage/'.$article->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $article->title }}">
                                @endif
                            </div>
                            <span class="font-mono text-[10px] text-bunny-violet tracking-widest mt-3 block">{{ strtoupper($article->categoryLabel()) }}</span>
                            <h3 class="font-display font-semibold mt-1 group-hover:text-bunny-violet transition-colors">{{ $article->title }}</h3>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layout>