<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'cover_image',
        'category',
        'excerpt',
        'content',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'interview' => 'Wawancara',
            'behind-the-scenes' => 'Behind The Scenes',
            'update' => 'Update',
            default => ucfirst($this->category),
        };
    }
}
