<x-admin-layout title="Tambah Produk">
    <nav class="text-xs font-mono tracking-widest text-bunny-graphite mb-2">
        <a href="{{ route('admin.products.index') }}" class="hover:text-bunny-violet">PRODUK</a>
        <span class="mx-1">/</span>
        <span class="text-bunny-ink">TAMBAH</span>
    </nav>
    <p class="text-sm text-bunny-graphite mb-6">Lengkapi detail produk baru di bawah ini.</p>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white border border-bunny-line rounded-2xl p-6 md:p-8">
        @include('admin.products._form')
    </form>
</x-admin-layout>
