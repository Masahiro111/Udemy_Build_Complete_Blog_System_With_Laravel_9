<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
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

        return view('post', compact(
            'post',
            'recent_posts',
            'categories',
            'tags',
        ));
    }
}
