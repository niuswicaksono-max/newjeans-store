<x-admin-layout title="Tulis Artikel">
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="bg-white border border-bunny-line rounded-2xl p-6">
        @include('admin.articles._form')
    </form>
</x-admin-layout>
