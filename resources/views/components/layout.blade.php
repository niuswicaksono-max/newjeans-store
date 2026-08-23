<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'NewJeans Store' }} — Official Bunnies Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bunny-cream text-bunny-ink font-sans antialiased">

    {{-- Y2K marquee ticker --}}
    <div class="bg-bunny-ink text-bunny-cream overflow-hidden py-2 text-xs tracking-wide">
        <div class="flex whitespace-nowrap marquee-track font-mono">
            @for ($i = 0; $i < 2; $i++)
                <span class="px-6">✦ NEW ARRIVALS EVERY MONTH</span>
                <span class="px-6">✦ FREE DIGITAL PHOTOCARD ON ORDERS ABOVE 300K</span>
                <span class="px-6">✦ BUNNIES WORLDWIDE</span>
                <span class="px-6">✦ GET READY WITH NEWJEANS</span>
            @endfor
        </div>
    </div>

    <header class="border-b border-bunny-line bg-bunny-cream/95 backdrop-blur sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-4 flex items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex flex-col leading-none group">
                <span class="font-display font-extrabold text-2xl tracking-tight group-hover:text-bunny-violet transition-colors">NEWJEANS</span>
                <span class="font-mono text-[10px] tracking-[0.3em] text-bunny-graphite">BUNNIES CLUB STORE</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-medium text-sm">
                <a href="{{ route('products.index') }}" class="hover:text-bunny-violet transition-colors {{ request()->routeIs('products.*') ? 'text-bunny-violet' : '' }}">Shop</a>
                <a href="{{ route('magazine.index') }}" class="hover:text-bunny-violet transition-colors {{ request()->routeIs('magazine.*') ? 'text-bunny-violet' : '' }}">Magazine</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('wishlist.index') }}" title="Wishlist" class="hover:text-bunny-violet transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
                    </a>
                    <a href="{{ route('cart.index') }}" title="Cart" class="hover:text-bunny-violet transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                    </a>
                    <div class="relative group">
                        <button class="w-8 h-8 rounded-full bg-bunny-lilac/40 border border-bunny-line flex items-center justify-center font-display text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-bunny-line rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all text-sm">
                            <div class="px-4 py-2 text-xs text-bunny-graphite border-b border-bunny-line">{{ auth()->user()->name }}</div>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-bunny-mist">Pesanan Saya</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-bunny-mist">Admin Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-bunny-mist text-red-500">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-bunny-violet transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-bunny-ink text-white px-4 py-2 rounded-full hover:bg-bunny-violet transition-colors">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="max-w-7xl mx-auto px-5 sm:px-8 mt-4">
            <div class="bg-bunny-lilac/30 border border-bunny-violet/40 text-bunny-deep text-sm rounded-lg px-4 py-3">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-5 sm:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-bunny-line mt-24 bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-14 grid grid-cols-2 md:grid-cols-4 gap-10">
            <div class="col-span-2">
                <span class="font-display font-extrabold text-xl">NEWJEANS</span>
                <p class="text-sm text-bunny-graphite mt-3 max-w-xs">Official merchandise & fan-hub untuk seluruh Bunnies. Belanja album, apparel, dan lightstick resmi — sambil update kabar terbaru dari Minji, Hanni, Haerin, Danielle, dan Hyein.</p>
            </div>
            <div>
                <p class="font-display text-xs font-bold tracking-wide mb-3">SHOP</p>
                <ul class="space-y-2 text-sm text-bunny-graphite">
                    <li><a href="{{ route('products.index', ['type' => 'merch']) }}" class="hover:text-bunny-violet">Merchandise</a></li>
                    <li><a href="{{ route('products.index', ['type' => 'album']) }}" class="hover:text-bunny-violet">Album</a></li>
                </ul>
            </div>
            <div>
                <p class="font-display text-xs font-bold tracking-wide mb-3">CLUB</p>
                <ul class="space-y-2 text-sm text-bunny-graphite">
                    <li><a href="{{ route('magazine.index') }}" class="hover:text-bunny-violet">Magazine</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:text-bunny-violet">Lacak Pesanan</a></li>
                </ul>
            </div>
        </div>
        <div class="perforated h-2"></div>
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-4 text-xs text-bunny-graphite font-mono">© {{ date('Y') }} NEWJEANS STORE — FAN-MADE PROJECT</div>
    </footer>
</body>
</html>