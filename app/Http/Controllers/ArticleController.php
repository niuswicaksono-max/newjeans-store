<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true)->with('author');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();

        return view('magazine.index', compact('articles'));
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        $article->load('author');

        $more = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('magazine.show', compact('article', 'more'));
    }
}
