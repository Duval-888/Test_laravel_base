<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Services\NotificationService;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:3'],
        ]);

        if ($topic->isLocked()) {
            return redirect()->route('topics.show', $topic->id)
                ->with('error', 'Ce sujet est verrouillé, vous ne pouvez plus répondre.');
        }

        $post = Post::create([
            'topic_id' => $topic->id,
            'user_id'  => auth()->id(),
            'content'  => $request->content,
        ]);

        // Notifier l'auteur du topic
        if ($topic->user_id !== auth()->id()) {
            $notificationService = new NotificationService();
            $notificationService->notifyReply($topic->user, auth()->user(), $post);
        }

        // Vérifier et attribuer les badges
        $badgeService = new BadgeService();
        $badgeService->checkAndAwardBadges(auth()->user());

        return redirect()->route('topics.show', $topic->id)
            ->with('success', 'Réponse ajoutée avec succès.');
    }
}