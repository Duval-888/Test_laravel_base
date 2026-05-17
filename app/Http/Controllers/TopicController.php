<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::with(['user', 'category'])
            ->withCount('posts')
            ->latest()
            ->get();

        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('topics.create', compact('categories'));
    }

   public function store(Request $request)
{
    $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'title'       => ['required', 'string', 'max:255'],
        'content'     => ['required', 'string', 'min:3'],
    ]);

    $baseSlug = Str::slug($request->title);
    $slug     = $baseSlug;
    $count    = 1;

    while (Topic::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $count;
        $count++;
    }

    $topic = Topic::create([
        'user_id'     => auth()->id(),
        'category_id' => $request->category_id,
        'title'       => $request->title,
        'content'     => $request->content,
        'slug'        => $slug,
    ]);

    // Notifier admins et modérateurs
    $notificationService = new \App\Services\NotificationService();
    $notificationService->notifyAdminsNewTopic(auth()->user(), $topic);

    return redirect()->route('topics.index')
        ->with('success', 'Question publiée avec succès.');
}

    public function show(Topic $topic)
    {
        // Incrémenter le compteur de vues
        $topic->incrementViews();

        $topic->load([
            'user',
            'category',
            'posts.user',
            'posts.votes',
        ]);

        return view('topics.show', compact('topic'));
    }
}