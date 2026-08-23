<x-layout title="Masuk">
    <section class="max-w-md mx-auto px-5 py-20">
        <div class="text-center mb-10">
            <span class="font-mono text-xs text-bunny-violet tracking-[0.3em]">WELCOME BACK</span>
            <h1 class="font-display font-extrabold text-3xl mt-2">Masuk ke Akunmu</h1>
            <p class="text-bunny-graphite text-sm mt-2">Belum jadi Bunny? <a href="{{ route('register') }}" class="text-bunny-violet font-semibold hover:underline">Daftar di sini</a></p>
        </div>

        <div class="bg-white border border-bunny-line rounded-3xl p-8 perforated">
            <div class="bg-white rounded-2xl p-2">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">EMAIL</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
                    </div>
                    <div>
                        <label class="text-xs font-mono tracking-widest text-bunny-graphite">PASSWORD</label>
                        <input type="password" name="password" required
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-bunny-graphite">
                        <input type="checkbox" name="remember" class="rounded border-bunny-line text-bunny-violet focus:ring-bunny-violet">
                        Ingat saya
                    </label>
                    <button type="submit" class="w-full bg-bunny-ink text-white font-semibold py-3 rounded-full hover:bg-bunny-violet transition-colors">Masuk</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
