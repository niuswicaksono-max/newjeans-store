<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed the default product categories.
     *
     * This is the missing piece that caused the "kategori tidak muncul"
     * (category dropdown is empty) issue on the admin > add product page:
     * the categories table was never populated, so the <select> had
     * nothing to loop through. Run `php artisan db:seed` (or
     * `php artisan migrate:fresh --seed`) after pulling this update.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Album', 'type' => 'album'],
            ['name' => 'Photocard', 'type' => 'album'],
            ['name' => 'Lightstick', 'type' => 'merch'],
            ['name' => 'Hoodie', 'type' => 'merch'],
            ['name' => 'T-Shirt', 'type' => 'merch'],
            ['name' => 'Aksesoris', 'type' => 'merch'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'type' => $category['type']]
            );
        }
    }
}
