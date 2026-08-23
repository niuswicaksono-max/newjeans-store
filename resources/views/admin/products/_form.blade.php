@csrf

@php
    $existingThumbnail = !empty($product) ? $product->thumbnail : null;
    $existingGalleryImages = !empty($product) ? $product->images : collect();
    $initialExistingCount = ($existingThumbnail ? 1 : 0) + $existingGalleryImages->count();
@endphp

@if ($categories->isEmpty())
    <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl px-4 py-3 mb-6">
        <span class="text-lg leading-none">⚠️</span>
        <div>
            <p class="font-semibold">Belum ada kategori.</p>
            <p class="mt-0.5">Dropdown kategori di bawah masih kosong karena belum ada data kategori sama sekali.
                <a href="{{ route('admin.categories.index') }}" class="underline font-semibold hover:text-amber-900">Tambah kategori dulu di sini</a>,
                baru produk bisa disimpan.</p>
        </div>
    </div>
@endif

@error('images')
    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3 mb-6">{{ $message }}</div>
@enderror

<div class="grid lg:grid-cols-5 gap-8">
    {{-- Left column: main product info --}}
    <div class="lg:col-span-3 space-y-8">
        <section>
            <h2 class="font-display font-semibold text-sm tracking-wide text-bunny-ink mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-bunny-violet/10 text-bunny-violet text-xs font-mono flex items-center justify-center">1</span>
                Informasi Produk
            </h2>

            <div class="space-y-5">
                <div>
                    <label for="name" class="text-xs font-mono tracking-widest text-bunny-graphite">NAMA PRODUK</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                        placeholder="cth. NewJeans — Get Up (Photobook Ver.)"
                        class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 text-sm placeholder:text-bunny-graphite/50 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="text-xs font-mono tracking-widest text-bunny-graphite">KATEGORI</label>
                    <select id="category_id" name="category_id" required
                        {{ $categories->isEmpty() ? 'disabled' : '' }}
                        class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition disabled:bg-bunny-mist disabled:text-bunny-graphite/60 disabled:cursor-not-allowed">
                        <option value="">{{ $categories->isEmpty() ? 'Belum ada kategori tersedia' : 'Pilih kategori' }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                                {{ $category->name }} · {{ $category->type === 'album' ? 'Album' : 'Merch' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="text-xs font-mono tracking-widest text-bunny-graphite">HARGA</label>
                        <div class="relative mt-2">
                            <span class="absolute inset-y-0 left-4 flex items-center text-sm text-bunny-graphite font-mono">Rp</span>
                            <input id="price" type="number" name="price" value="{{ old('price', $product->price ?? '') }}" min="0" required
                                class="w-full border border-bunny-line rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition">
                        </div>
                        @error('price')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stock" class="text-xs font-mono tracking-widest text-bunny-graphite">STOK</label>
                        <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" min="0" required
                            class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition">
                        @error('stock')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="text-xs font-mono tracking-widest text-bunny-graphite">DESKRIPSI</label>
                    <textarea id="description" name="description" rows="5"
                        placeholder="Ceritakan detail produk: isi paket, ukuran, bahan, dsb."
                        class="w-full mt-2 border border-bunny-line rounded-xl px-4 py-3 text-sm placeholder:text-bunny-graphite/50 focus:outline-none focus:ring-2 focus:ring-bunny-violet/40 focus:border-bunny-violet transition">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 bg-bunny-mist rounded-xl px-4 py-3 text-sm cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))
                        class="rounded border-bunny-line text-bunny-violet focus:ring-bunny-violet">
                    <span>
                        <span class="font-medium block">Tampilkan produk di toko</span>
                        <span class="text-bunny-graphite text-xs">Jika dimatikan, produk disimpan sebagai draft dan tidak tampil ke pembeli.</span>
                    </span>
                </label>
            </div>
        </section>
    </div>

    {{-- Right column: photos --}}
    <div class="lg:col-span-2 space-y-4">
        <section>
            <h2 class="font-display font-semibold text-sm tracking-wide text-bunny-ink mb-1 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-bunny-violet/10 text-bunny-violet text-xs font-mono flex items-center justify-center">2</span>
                Foto Produk
            </h2>
            <p class="text-xs text-bunny-graphite mb-4 ml-8">Maksimal 4 foto. Klik <span class="font-semibold">Utama</span> di salah satu foto untuk jadikan foto sampul (thumbnail).</p>

            <div id="photo-grid" class="grid grid-cols-2 gap-3">
                @if ($existingThumbnail)
                    <div class="image-tile relative rounded-xl overflow-hidden border-2 border-bunny-violet aspect-square" data-slot="thumbnail">
                        <img src="{{ asset('storage/'.$existingThumbnail) }}" class="w-full h-full object-cover">
                        <label class="absolute top-2 left-2 flex items-center gap-1 bg-white shadow rounded-full pl-1.5 pr-2.5 py-1 text-[11px] font-semibold cursor-pointer select-none">
                            <input type="radio" name="primary_source" value="current" checked class="accent-bunny-violet w-3.5 h-3.5">
                            Utama
                        </label>
                        <button type="button" onclick="removeExistingTile(this)" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white shadow text-red-500 hover:bg-red-50 flex items-center justify-center text-sm">✕</button>
                        <input type="checkbox" name="delete_thumbnail" value="1" class="hidden delete-flag">
                    </div>
                @endif

                @foreach ($existingGalleryImages as $img)
                    <div class="image-tile relative rounded-xl overflow-hidden border-2 border-transparent aspect-square" data-slot="existing-{{ $img->id }}">
                        <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-full object-cover">
                        <label class="absolute top-2 left-2 flex items-center gap-1 bg-white shadow rounded-full pl-1.5 pr-2.5 py-1 text-[11px] font-semibold cursor-pointer select-none">
                            <input type="radio" name="primary_source" value="existing:{{ $img->id }}" class="accent-bunny-violet w-3.5 h-3.5">
                            Utama
                        </label>
                        <button type="button" onclick="removeExistingTile(this)" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white shadow text-red-500 hover:bg-red-50 flex items-center justify-center text-sm">✕</button>
                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="hidden delete-flag">
                    </div>
                @endforeach

                <div id="new-tiles-container" class="contents"></div>

                <button type="button" id="add-photo-tile"
                    class="aspect-square border-2 border-dashed border-bunny-line rounded-xl flex flex-col items-center justify-center gap-1 text-bunny-graphite hover:border-bunny-violet hover:text-bunny-violet hover:bg-bunny-lilac/10 transition">
                    <span class="text-2xl leading-none">+</span>
                    <span class="text-xs font-medium">Tambah Foto</span>
                </button>
            </div>

            <p id="photo-counter" class="text-xs text-bunny-graphite mt-3"></p>

            <input type="file" id="file-picker" accept="image/*" multiple class="hidden">
            <input type="file" id="images-submit-input" name="images[]" multiple class="hidden">

            @error('primary_source')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </section>
    </div>
</div>

<div class="flex items-center gap-3 mt-8 pt-6 border-t border-bunny-line">
    <button type="submit" class="bg-bunny-ink text-white font-semibold px-8 py-3 rounded-full hover:bg-bunny-violet transition-colors">
        {{ !empty($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="text-sm text-bunny-graphite hover:text-bunny-ink px-4 py-3">Batal</a>
</div>

<script>
    (function () {
        const MAX_IMAGES = 4;
        let existingCount = {{ $initialExistingCount }};
        let newFiles = [];

        const grid = document.getElementById('photo-grid');
        const newTilesContainer = document.getElementById('new-tiles-container');
        const addTile = document.getElementById('add-photo-tile');
        const filePicker = document.getElementById('file-picker');
        const submitInput = document.getElementById('images-submit-input');
        const counter = document.getElementById('photo-counter');

        function totalCount() {
            return existingCount + newFiles.length;
        }

        function updateCounter() {
            const total = totalCount();
            counter.textContent = total + ' dari ' + MAX_IMAGES + ' foto digunakan';
            addTile.classList.toggle('hidden', total >= MAX_IMAGES);
        }

        function ensureDefaultPrimary() {
            const checked = grid.querySelector('input[name="primary_source"]:checked');
            if (checked) {
                const tile = checked.closest('.image-tile');
                if (!tile || tile.style.display === 'none') {
                    checked.checked = false;
                } else {
                    return;
                }
            }
            const firstAvailable = grid.querySelector('.image-tile:not([style*="display: none"]) input[name="primary_source"]');
            if (firstAvailable) firstAvailable.checked = true;
        }

        function syncSubmitInput() {
            const dt = new DataTransfer();
            newFiles.forEach((file) => dt.items.add(file));
            submitInput.files = dt.files;
        }

        function renderNewTiles() {
            newTilesContainer.innerHTML = '';
            newFiles.forEach((file, index) => {
                const url = URL.createObjectURL(file);
                const tile = document.createElement('div');
                tile.className = 'image-tile relative rounded-xl overflow-hidden border-2 border-transparent aspect-square';
                tile.dataset.slot = 'new-' + index;
                tile.innerHTML = `
                    <img src="${url}" class="w-full h-full object-cover">
                    <label class="absolute top-2 left-2 flex items-center gap-1 bg-white shadow rounded-full pl-1.5 pr-2.5 py-1 text-[11px] font-semibold cursor-pointer select-none">
                        <input type="radio" name="primary_source" value="new:${index}" class="accent-bunny-violet w-3.5 h-3.5">
                        Utama
                    </label>
                    <button type="button" data-new-index="${index}" class="remove-new-tile absolute top-2 right-2 w-7 h-7 rounded-full bg-white shadow text-red-500 hover:bg-red-50 flex items-center justify-center text-sm">✕</button>
                `;
                newTilesContainer.appendChild(tile);
            });

            newTilesContainer.querySelectorAll('.remove-new-tile').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const idx = parseInt(this.dataset.newIndex, 10);
                    newFiles.splice(idx, 1);
                    renderNewTiles();
                    syncSubmitInput();
                    updateCounter();
                    ensureDefaultPrimary();
                });
            });
        }

        window.removeExistingTile = function (button) {
            const tile = button.closest('.image-tile');
            const flag = tile.querySelector('.delete-flag');
            if (flag) flag.checked = true;
            tile.style.display = 'none';
            existingCount -= 1;
            updateCounter();
            ensureDefaultPrimary();
        };

        addTile.addEventListener('click', function () {
            const remaining = MAX_IMAGES - totalCount();
            if (remaining <= 0) return;
            filePicker.click();
        });

        filePicker.addEventListener('change', function () {
            const remaining = MAX_IMAGES - totalCount();
            const chosen = Array.from(this.files || []).slice(0, Math.max(remaining, 0));
            newFiles = newFiles.concat(chosen);
            this.value = '';
            renderNewTiles();
            syncSubmitInput();
            updateCounter();
            ensureDefaultPrimary();
        });

        updateCounter();
    })();
</script>
