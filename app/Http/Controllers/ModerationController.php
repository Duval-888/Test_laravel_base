<?php

namespace App\Http\Controllers;

use App\Models\ModerationLog;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    /**
     * Delete a post (moderation)
     */
    public function deletePost(Request $request, Post $post)
    {
        $this->authorize('delete', $post);
        
        $validated = $request->validate([
            'reason' => 'required|string|min:5',
        ]);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'post_id' => $post->id,
            'action' => 'delete',
            'reason' => $validated['reason'],
        ]);

        $post->update(['is_approved' => false]);
        return response()->json(['message' => 'Post has been removed']);
    }

    /**
     * Suspend a topic
     */
    public function suspendTopic(Request $request, Topic $topic)
    {
        $this->authorize('moderate', $topic);
        
        $validated = $request->validate([
            'reason' => 'required|string|min:5',
        ]);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'topic_id' => $topic->id,
            'action' => 'suspend',
            'reason' => $validated['reason'],
        ]);

        $topic->update(['is_locked' => true]);
        return response()->json(['message' => 'Topic has been suspended']);
    }

    /**
     * Get moderation logs
     */
    public function getLogs(Request $request)
    {
        $this->authorize('viewAny', ModerationLog::class);
        
        $logs = ModerationLog::with('moderator', 'post', 'topic')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return response()->json(['data' => $logs]);
    }

    /**
     * Restore a post
     */
    public function restore(Request $request, Post $post)
    {
        $this->authorize('delete', $post);
        
        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        ModerationLog::create([
            'moderator_id' => auth()->id(),
            'post_id' => $post->id,
            'action' => 'restore',
            'reason' => $validated['reason'],
        ]);

        $post->update(['is_approved' => true]);
        return response()->json(['message' => 'Post has been restored']);
    }
}
