<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;

class BadgeService
{
    /**
     * Award badge to user
     */
    public function awardBadge(User $user, Badge $badge): bool
    {
        $existingBadge = UserBadge::where('user_id', $user->id)
            ->where('badge_id', $badge->id)
            ->exists();

        if (!$existingBadge) {
            UserBadge::create([
                'user_id' => $user->id,
                'badge_id' => $badge->id,
            ]);
            return true;
        }

        return false;
    }

    /**
     * Check if user has badge
     */
    public function hasBadge(User $user, Badge $badge): bool
    {
        return UserBadge::where('user_id', $user->id)
            ->where('badge_id', $badge->id)
            ->exists();
    }

    /**
     * Get user total badges count
     */
    public function getUserBadgesCount(User $user): int
    {
        return $user->badges()->count();
    }

    /**
     * Check and award badges based on user activity
     */
    public function checkAndAwardBadges(User $user): array
    {
        $awardedBadges = [];

        // Badge for first post (if applicable)
        $postsCount = $user->posts()->count();
        if ($postsCount === 1) {
            $badge = Badge::where('criteria', 'first_post')->first();
            if ($badge && $this->awardBadge($user, $badge)) {
                $awardedBadges[] = $badge;
            }
        }

        // Badge for 10 posts
        if ($postsCount === 10) {
            $badge = Badge::where('criteria', '10_posts')->first();
            if ($badge && $this->awardBadge($user, $badge)) {
                $awardedBadges[] = $badge;
            }
        }

        // Badge for active user (helpful replies)
        $likedPostsCount = $user->posts()
            ->where('votes_count', '>=', 5)
            ->count();

        if ($likedPostsCount >= 3) {
            $badge = Badge::where('criteria', 'helpful_member')->first();
            if ($badge && $this->awardBadge($user, $badge)) {
                $awardedBadges[] = $badge;
            }
        }

        return $awardedBadges;
    }

    /**
     * Remove badge from user
     */
    public function removeBadge(User $user, Badge $badge): bool
    {
        return (bool) UserBadge::where('user_id', $user->id)
            ->where('badge_id', $badge->id)
            ->delete();
    }
}
