<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Topic;

class NotificationService
{
    /**
     * Notifier l'auteur du topic qu'une réponse a été postée
     */
    public function notifyReply(User $recipient, User $sender, Post $newPost): Notification
    {
        return Notification::create([
            'user_id'      => $recipient->id,
            'from_user_id' => $sender->id,
            'post_id'      => $newPost->id,
            'type'         => 'reply',
            'is_read'      => false,
        ]);
    }

    /**
     * Notifier tous les admins et modérateurs qu'un nouveau topic a été créé
     */
    public function notifyAdminsNewTopic(User $author, Topic $topic): void
    {
        $adminsAndMods = User::whereIn('role', ['admin', 'moderator'])->get();

        foreach ($adminsAndMods as $admin) {
            if ($admin->id === $author->id) continue;

            // On utilise post_id nullable — on crée une notif sans post
            Notification::create([
                'user_id'      => $admin->id,
                'from_user_id' => $author->id,
                'post_id'      => null,
                'type'         => 'status_change',
                'is_read'      => false,
            ]);
        }
    }

    /**
     * Notifier l'auteur d'un post que sa réponse a été notée
     */
    public function notifyRated(User $recipient, User $rater, Post $post): void
    {
        // Eviter les doublons récents
        $existing = Notification::where('user_id', $recipient->id)
            ->where('from_user_id', $rater->id)
            ->where('post_id', $post->id)
            ->where('type', 'likes')
            ->where('created_at', '>', now()->subHour())
            ->first();

        if (!$existing) {
            Notification::create([
                'user_id'      => $recipient->id,
                'from_user_id' => $rater->id,
                'post_id'      => $post->id,
                'type'         => 'likes',
                'is_read'      => false,
            ]);
        }
    }

    public function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

    public function markAllAsRead(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}