<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use App\Models\ModerationLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_categories' => Category::count(),
            'total_topics'     => Topic::count(),
            'total_posts'      => Post::count(),
        ];

        $recentLogs = ModerationLog::with('moderator')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLogs'));
    }

    public function categories()
    {
        $categories = Category::withCount('topics')->latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $baseSlug = Str::slug($request->name);
        $slug     = $baseSlug;
        $counter  = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        Category::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Catégorie supprimée avec succès.');
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:user,moderator,admin'],
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function roles()
    {
        $users = User::latest()->get();
        return view('admin.roles', compact('users'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function logs()
    {
        $logs = ModerationLog::with('moderator', 'post', 'topic')
            ->latest()
            ->paginate(20);

        return view('admin.logs', compact('logs'));
    }

    public function moderation()
    {
        $posts = Post::with('user', 'topic')
            ->where('is_approved', false)
            ->latest()
            ->paginate(20);

        return view('admin.moderation', compact('posts'));
    }

    public function restorePost(Request $request, Post $post)
    {
        $post->update(['is_approved' => true]);
        return redirect()->route('admin.moderation')->with('success', 'Post approuvé avec succès.');
    }

    public function topics()
    {
        $topics = Topic::with(['user', 'category'])
            ->withCount('posts')
            ->latest()
            ->paginate(20);

        return view('admin.topics', compact('topics'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->with('fromUser', 'post.topic')
            ->latest()
            ->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    public function markAllNotificationsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('admin.notifications')
            ->with('success', 'Toutes les notifications sont marquées comme lues.');
    }
}