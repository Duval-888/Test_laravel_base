<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes (no auth required)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/topics', [TopicController::class, 'index']);
Route::get('/topics/{topic}', [TopicController::class, 'show']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/votes/post/{post}', [VoteController::class, 'getVotes']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Category management (admin only)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Topic management
    Route::post('/topics', [TopicController::class, 'store']);
    Route::put('/topics/{topic}', [TopicController::class, 'update']);
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy']);

    // Post (messages) management
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Voting system
    Route::post('/posts/{post}/vote', [VoteController::class, 'vote']);

    // Moderation
    Route::post('/moderation/posts/{post}/delete', [ModerationController::class, 'deletePost']);
    Route::post('/moderation/posts/{post}/restore', [ModerationController::class, 'restore']);
    Route::post('/moderation/topics/{topic}/suspend', [ModerationController::class, 'suspendTopic']);
    Route::get('/moderation/logs', [ModerationController::class, 'getLogs']);

    // Badge system
    Route::post('/badges', [BadgeController::class, 'store']);
    Route::get('/users/{user}/badges', [BadgeController::class, 'getUserBadges']);
    Route::post('/users/{user}/badges/{badge}', [BadgeController::class, 'assignBadge']);
    Route::delete('/users/{user}/badges/{badge}', [BadgeController::class, 'removeBadge']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);
    Route::delete('/notifications', [NotificationController::class, 'destroyAll']);
});

