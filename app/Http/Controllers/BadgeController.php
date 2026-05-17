<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display all badges
     */
    public function index()
    {
        $badges = Badge::all();
        return response()->json(['data' => $badges]);
    }

    /**
     * Create a new badge (admin only)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Badge::class);
        
        $validated = $request->validate([
            'name' => 'required|string|unique:badges',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'criteria' => 'nullable|string',
        ]);

        $badge = Badge::create($validated);
        return response()->json(['data' => $badge], 201);
    }

    /**
     * Get user badges
     */
    public function getUserBadges(User $user)
    {
        $badges = $user->badges()->withPivot('earned_at')->get();
        return response()->json(['data' => $badges]);
    }

    /**
     * Assign badge to user (admin only)
     */
    public function assignBadge(Request $request, User $user)
    {
        $this->authorize('create', Badge::class);
        
        $validated = $request->validate([
            'badge_id' => 'required|exists:badges,id',
        ]);

        $userBadge = UserBadge::updateOrCreate(
            ['user_id' => $user->id, 'badge_id' => $validated['badge_id']],
            ['earned_at' => now()]
        );
        
        return response()->json(['data' => $userBadge], 201);
    }

    /**
     * Remove badge from user
     */
    public function removeBadge(User $user, Badge $badge)
    {
        $this->authorize('delete', Badge::class);
        
        UserBadge::where('user_id', $user->id)
            ->where('badge_id', $badge->id)
            ->delete();
            
        return response()->json(['message' => 'Badge removed']);
    }
}
