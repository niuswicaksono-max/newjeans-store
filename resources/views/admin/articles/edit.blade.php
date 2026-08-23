<x-admin-layout title="Edit Artikel">
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="bg-white border border-bunny-line rounded-2xl p-6">
        @method('PUT')
        @include('admin.articles._form')
    </form>
</x-admin-layout>
