<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Models\ModerationLog;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'posts_signales'  => Post::where('is_approved', false)->count(),
            'topics_count'    => Topic::count(),
            'topics_lockés'   => Topic::where('is_locked', true)->count(),
            'mes_actions'     => ModerationLog::where('moderator_id', auth()->id())->count(),
        ];

        $recentLogs = ModerationLog::where('moderator_id', auth()->id())
            ->with('post', 'topic')
            ->latest()
            ->take(5)
            ->get();

        return view('moderator.dashboard', compact('stats', 'recentLogs'));
    }

    public function posts()
    {
        $posts = Post::with('user', 'topic')
            ->where('is_approved', false)
            ->latest()
            ->paginate(20);

        return view('moderator.posts', compact('posts'));
    }

    public function restorePost(Request $request, Post $post)
    {
        $request->validate(['reason' => 'required|string|min:3']);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'post_id'      => $post->id,
            'action'       => 'restore',
            'reason'       => $request->reason,
        ]);

        $post->update(['is_approved' => true]);
        return redirect()->route('moderator.posts')->with('success', 'Post approuvé.');
    }

    public function deletePost(Request $request, Post $post)
    {
        $request->validate(['reason' => 'required|string|min:3']);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'post_id'      => $post->id,
            'action'       => 'delete',
            'reason'       => $request->reason,
        ]);

        $post->update(['is_approved' => false]);
        return redirect()->route('moderator.posts')->with('success', 'Post supprimé.');
    }

    public function topics()
    {
        $topics = Topic::with(['user', 'category'])
            ->withCount('posts')
            ->latest()
            ->paginate(20);

        return view('moderator.topics', compact('topics'));
    }

    public function lockTopic(Request $request, Topic $topic)
    {
        $request->validate(['reason' => 'required|string|min:3']);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'topic_id'     => $topic->id,
            'action'       => 'suspend',
            'reason'       => $request->reason,
        ]);

        $topic->update(['is_locked' => true]);
        return redirect()->route('moderator.topics')->with('success', 'Sujet verrouillé.');
    }

    public function unlockTopic(Request $request, Topic $topic)
    {
        $request->validate(['reason' => 'required|string|min:3']);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'topic_id'     => $topic->id,
            'action'       => 'restore',
            'reason'       => $request->reason,
        ]);

        $topic->update(['is_locked' => false]);
        return redirect()->route('moderator.topics')->with('success', 'Sujet déverrouillé.');
    }

    public function logs()
    {
        $logs = ModerationLog::where('moderator_id', auth()->id())
            ->with('post', 'topic')
            ->latest()
            ->paginate(20);

        return view('moderator.logs', compact('logs'));
    }

    public function notifications()
{
    $notifications = \App\Models\Notification::where('user_id', auth()->id())
        ->with('fromUser', 'post.topic')
        ->latest()
        ->paginate(20);

    return view('moderator.notifications', compact('notifications'));
}

public function markAllNotificationsRead()
{
    \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return redirect()->route('moderator.notifications')->with('success', 'Toutes les notifications sont marquées comme lues.');
}
}