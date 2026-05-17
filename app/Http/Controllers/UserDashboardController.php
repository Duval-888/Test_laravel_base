<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Models\Vote;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'topics_count' => Topic::where('user_id', $user->id)->count(),
            'posts_count' => Post::where('user_id', $user->id)->count(),
            'votes_count' => Vote::where('user_id', $user->id)->count(),
        ];

        $latestTopics = Topic::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $latestPosts = Post::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('user', 'stats', 'latestTopics', 'latestPosts'));
    }
}