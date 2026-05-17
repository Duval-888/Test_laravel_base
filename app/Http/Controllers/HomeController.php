<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('topics')->get();

        $recentTopics = Topic::with('user', 'category')
            ->withCount('posts')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'total_topics' => Topic::count(),
            'total_posts'  => Post::count(),
            'total_users'  => User::count(),
        ];

        return view('home', compact('categories', 'recentTopics', 'stats'));
    }
}