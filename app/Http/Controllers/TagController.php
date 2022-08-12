<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
    }

    public function show(Tag $tag)
    {
        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $tags = Tag::query()
            ->take(50)
            ->get();

        return view('tags.show', [
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,

            'posts' => $tag->posts()->paginate(10),
            'tag' => $tag,
        ]);
    }
}
