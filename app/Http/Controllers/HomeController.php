<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $latestArticles = Article::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('featuredProducts', 'latestArticles'));
    }
}
