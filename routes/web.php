<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ModeratorController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Catégories côté public
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Topics — create AVANT {topic} pour éviter le conflit
Route::middleware('auth')->group(function () {
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::post('/topics/{topic}/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/vote', [VoteController::class, 'store'])->name('posts.vote');
});

// Topics publics — APRÈS les routes auth
Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');

// Espace utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Espace modérateur
Route::middleware(['auth', 'moderator'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/dashboard', [ModeratorController::class, 'dashboard'])->name('dashboard');

    Route::get('/posts', [ModeratorController::class, 'posts'])->name('posts');
    Route::patch('/posts/{post}/restore', [ModeratorController::class, 'restorePost'])->name('posts.restore');
    Route::patch('/posts/{post}/delete', [ModeratorController::class, 'deletePost'])->name('posts.delete');

    Route::get('/topics', [ModeratorController::class, 'topics'])->name('topics');
    Route::patch('/topics/{topic}/lock', [ModeratorController::class, 'lockTopic'])->name('topics.lock');
    Route::patch('/topics/{topic}/unlock', [ModeratorController::class, 'unlockTopic'])->name('topics.unlock');

    Route::get('/logs', [ModeratorController::class, 'logs'])->name('logs');

    Route::get('/notifications', [ModeratorController::class, 'notifications'])->name('notifications');
Route::patch('/notifications/read-all', [ModeratorController::class, 'markAllNotificationsRead'])->name('notifications.readAll');
});

// Administration
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminDashboardController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminDashboardController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/roles', [AdminDashboardController::class, 'roles'])->name('roles');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    Route::get('/logs', [AdminDashboardController::class, 'logs'])->name('logs');
    Route::get('/moderation', [AdminDashboardController::class, 'moderation'])->name('moderation');
    Route::patch('/moderation/{post}/restore', [AdminDashboardController::class, 'restorePost'])->name('moderation.restore');
    Route::get('/topics', [AdminDashboardController::class, 'topics'])->name('topics');
    Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('notifications');
    Route::patch('/notifications/read-all', [AdminDashboardController::class, 'markAllNotificationsRead'])->name('notifications.readAll');
});