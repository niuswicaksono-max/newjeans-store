<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /** Maximum number of photos (thumbnail + gallery combined) a product can have. */
    private const MAX_IMAGES = 4;

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $hasCategories = Category::exists();

        return view('admin.products.index', compact('products', 'hasCategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $newImages = $request->file('images', []);

        if (count($newImages) > self::MAX_IMAGES) {
            return back()->withInput()->withErrors([
                'images' => 'Maksimal '.self::MAX_IMAGES.' foto per produk.',
            ]);
        }

        $primaryIndex = $this->resolveNewPrimaryIndex($request->input('primary_source'), count($newImages));

        $thumbnailPath = null;
        $galleryPaths = [];

        foreach ($newImages as $index => $file) {
            $path = $file->store('products', 'public');

            if ($index === $primaryIndex) {
                $thumbnailPath = $path;
            } else {
                $galleryPaths[] = $path;
            }
        }

        $data['thumbnail'] = $thumbnailPath;
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        unset($data['images'], $data['primary_source'], $data['delete_images'], $data['delete_thumbnail']);

        $product = Product::create($data);

        foreach ($galleryPaths as $path) {
            $product->images()->create(['path' => $path]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);

        $deleteIds = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id)->all();
        $deleteThumbnail = $request->boolean('delete_thumbnail');
        $newImages = $request->file('images', []);

        $keepingThumbnail = $product->thumbnail && ! $deleteThumbnail;
        $remainingGalleryCount = $product->images()->whereNotIn('id', $deleteIds)->count();
        $total = ($keepingThumbnail ? 1 : 0) + $remainingGalleryCount + count($newImages);

        if ($total > self::MAX_IMAGES) {
            return back()->withInput()->withErrors([
                'images' => 'Maksimal '.self::MAX_IMAGES.' foto per produk. Hapus foto lama dulu kalau mau tambah yang baru.',
            ]);
        }

        // 1. Delete requested gallery images.
        if (! empty($deleteIds)) {
            $product->images()->whereIn('id', $deleteIds)->get()->each(function ($image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            });
        }

        // 2. Work out the new thumbnail based on what the admin picked.
        $currentThumbnail = $deleteThumbnail ? null : $product->thumbnail;
        $primarySource = $request->input('primary_source');
        $newThumbnailPath = $currentThumbnail;
        $demotedOldThumbnail = false;

        if ($primarySource && str_starts_with($primarySource, 'existing:')) {
            $imageId = (int) substr($primarySource, strlen('existing:'));
            $chosen = $product->images()->whereKey($imageId)->whereNotIn('id', $deleteIds)->first();

            if ($chosen) {
                $newThumbnailPath = $chosen->path;
                $chosen->delete(); // it's becoming the thumbnail, so it leaves the gallery table
                $demotedOldThumbnail = true;
            }
        } elseif ($primarySource && str_starts_with($primarySource, 'new:')) {
            $index = (int) substr($primarySource, strlen('new:'));

            if (isset($newImages[$index])) {
                $newThumbnailPath = $newImages[$index]->store('products', 'public');
                $demotedOldThumbnail = true;
                unset($newImages[$index]);
            }
        }

        // If the old thumbnail got replaced, keep it around as a gallery photo instead of deleting it.
        if ($demotedOldThumbnail && $currentThumbnail) {
            $product->images()->create(['path' => $currentThumbnail]);
        }

        if ($deleteThumbnail && $product->thumbnail && ! $demotedOldThumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        // 3. Store any remaining new uploads (not chosen as primary) into the gallery.
        foreach ($newImages as $file) {
            $path = $file->store('products', 'public');
            $product->images()->create(['path' => $path]);
        }

        // 4. If there's still no thumbnail but photos exist, promote the first gallery photo.
        if (! $newThumbnailPath) {
            $fallback = $product->images()->first();

            if ($fallback) {
                $newThumbnailPath = $fallback->path;
                $fallback->delete();
            }
        }

        $data['thumbnail'] = $newThumbnailPath;

        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        $data['is_active'] = $request->boolean('is_active');
        unset($data['images'], $data['primary_source'], $data['delete_images'], $data['delete_thumbnail']);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', 'Produk dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['nullable', 'array', 'max:'.self::MAX_IMAGES],
            'images.*' => ['image', 'max:2048'],
            'primary_source' => ['nullable', 'string'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer'],
            'delete_thumbnail' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Work out which of the freshly uploaded files (if any) should become the
     * thumbnail for a brand-new product. Defaults to the first uploaded photo
     * if the admin didn't explicitly pick one.
     */
    private function resolveNewPrimaryIndex(?string $primarySource, int $newImageCount): ?int
    {
        if ($newImageCount === 0) {
            return null;
        }

        if ($primarySource && str_starts_with($primarySource, 'new:')) {
            $index = (int) substr($primarySource, strlen('new:'));

            if ($index >= 0 && $index < $newImageCount) {
                return $index;
            }
        }

        return 0;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original.'-'.$i++;
        }

        return $slug;
    }
}
