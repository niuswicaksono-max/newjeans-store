<x-admin-layout title="Edit Produk">
    <nav class="text-xs font-mono tracking-widest text-bunny-graphite mb-2">
        <a href="{{ route('admin.products.index') }}" class="hover:text-bunny-violet">PRODUK</a>
        <span class="mx-1">/</span>
        <span class="text-bunny-ink">{{ strtoupper($product->name) }}</span>
    </nav>
    <p class="text-sm text-bunny-graphite mb-6">Perbarui detail produk ini.</p>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white border border-bunny-line rounded-2xl p-6 md:p-8">
        @method('PUT')
        @include('admin.products._form')
    </form>
</x-admin-layout>
