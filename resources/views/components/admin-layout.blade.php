<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — NewJeans Store Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bunny-mist text-bunny-ink font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-bunny-ink text-white flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-white/10">
                <span class="font-display font-extrabold text-lg">NEWJEANS</span>
                <span class="font-mono text-[10px] tracking-widest text-white/50 block">ADMIN PANEL</span>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-bunny-violet' : 'hover:bg-white/10' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-bunny-violet' : 'hover:bg-white/10' }}">Produk</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-bunny-violet' : 'hover:bg-white/10' }}">Kategori</a>
                <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-bunny-violet' : 'hover:bg-white/10' }}">Pesanan</a>
                <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-bunny-violet' : 'hover:bg-white/10' }}">Magazine (CMS)</a>
            </nav>
            <div class="px-3 py-4 border-t border-white/10 space-y-1 text-sm">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-white/10">← Lihat Website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-white/10 text-red-300">Keluar</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-bunny-line px-8 py-5">
                <h1 class="font-display font-bold text-xl">{{ $title ?? 'Dashboard' }}</h1>
            </header>

            <main class="flex-1 p-8">
                @if (session('status'))
                    <div class="bg-bunny-lilac/30 border border-bunny-violet/40 text-bunny-deep text-sm rounded-lg px-4 py-3 mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
