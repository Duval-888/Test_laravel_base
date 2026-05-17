<?php

namespace App\Services;

use App\Models\Vote;
use App\Models\Post;
use App\Models\User;

class VotingService
{
    /**
     * Cast a vote on a post
     */
    public function vote(User $user, Post $post, string $type): array
    {
        $existingVote = Vote::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // Remove vote if same type
                $existingVote->delete();
                $post->decrement('votes_count');
                return ['action' => 'removed', 'vote' => null];
            } else {
                // Update vote if different type
                $existingVote->update(['type' => $type]);
                return ['action' => 'updated', 'vote' => $existingVote];
            }
        }

        // Create new vote
        $vote = Vote::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => $type,
        ]);

        $post->increment('votes_count');
        return ['action' => 'created', 'vote' => $vote];
    }

    /**
     * Get voting statistics for a post
     */
    public function getVoteStats(Post $post): array
    {
        return [
            'likes' => $post->votes()->where('type', 'like')->count(),
            'dislikes' => $post->votes()->where('type', 'dislike')->count(),
            'total' => $post->votes_count,
        ];
    }

    /**
     * Get user vote for a post
     */
    public function getUserVote(User $user, Post $post): ?string
    {
        $vote = $post->votes()
            ->where('user_id', $user->id)
            ->first();

        return $vote?->type;
    }
}
