<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'value' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        if ($post->user_id == auth()->id()) {
            return back()->with('error', 'Tu ne peux pas noter ta propre réponse.');
        }

        Vote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ],
            [
                'type'  => 'rating',
                'value' => $request->value,
            ]
        );

        // Notifier l'auteur du post
        $notificationService = new NotificationService();
        $notificationService->notifyRated($post->user, auth()->user(), $post);

        return back()->with('success', 'Note enregistrée avec succès.');
    }
}