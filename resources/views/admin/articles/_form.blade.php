@csrf

<div class="grid md:grid-cols-2 gap-6">
    <div class="space-y-5">
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite">JUDUL</label>
            <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" required
                class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
        </div>
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite">KATEGORI</label>
            <select name="category" required class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">
                <option value="interview" @selected(old('category', $article->category ?? '') === 'interview')>Wawancara</option>
                <option value="behind-the-scenes" @selected(old('category', $article->category ?? '') === 'behind-the-scenes')>Behind The Scenes</option>
                <option value="update" @selected(old('category', $article->category ?? '') === 'update')>Update</option>
            </select>
        </div>
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite">RINGKASAN (EXCERPT)</label>
            <textarea name="excerpt" rows="3" class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $article->is_published ?? false)) class="rounded border-bunny-line text-bunny-violet focus:ring-bunny-violet">
            Publikasikan sekarang
        </label>
    </div>

    <div class="space-y-5">
        <div>
            <label class="text-xs font-mono tracking-widest text-bunny-graphite">FOTO COVER</label>
            @if (!empty($article) && $article->cover_image)
                <img src="{{ asset('storage/'.$article->cover_image) }}" class="w-full aspect-video object-cover rounded-xl border border-bunny-line mt-2 mb-2">
            @endif
            <input type="file" name="cover_image" accept="image/*" class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 text-sm">
        </div>
    </div>
</div>

<div class="mt-6">
    <label class="text-xs font-mono tracking-widest text-bunny-graphite">ISI ARTIKEL</label>
    <textarea name="content" rows="12" required class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40">{{ old('content', $article->content ?? '') }}</textarea>
</div>

<button type="submit" class="mt-8 bg-bunny-ink text-white font-semibold px-8 py-3 rounded-full hover:bg-bunny-violet transition-colors">Simpan Artikel</button>
