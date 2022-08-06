<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::query()
            ->withCount('comments')
            ->get();

        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('posts', 'recent_posts'));
    }
}
