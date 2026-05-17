@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="stat-cards">
    <div class="stat-card blue">
        <div class="icon">👥</div>
        <h3>Utilisateurs</h3>
        <p>{{ $stats['total_users'] }}</p>
    </div>
    <div class="stat-card purple">
        <div class="icon">🗂️</div>
        <h3>Catégories</h3>
        <p>{{ $stats['total_categories'] }}</p>
    </div>
    <div class="stat-card green">
        <div class="icon">💬</div>
        <h3>Sujets</h3>
        <p>{{ $stats['total_topics'] }}</p>
    </div>
    <div class="stat-card orange">
        <div class="icon">📝</div>
        <h3>Messages</h3>
        <p>{{ $stats['total_posts'] }}</p>
    </div>
</div>

<div class="panel">
    <h2>Activités de modération récentes</h2>
    @forelse($recentLogs as $log)
        <div style="padding:14px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
            <div>
                <strong style="color:#0f172a;">{{ $log->moderator->name ?? 'Système' }}</strong>
                <span style="background:#ede9fe; color:#6d28d9; padding:3px 10px; border-radius:20px; font-size:12px; margin-left:8px;">
                    {{ $log->action }}
                </span>
                <p style="color:#64748b; margin-top:4px; font-size:14px;">{{ $log->reason }}</p>
            </div>
            <span style="color:#94a3b8; font-size:13px;">{{ $log->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucune activité récente.</p>
    @endforelse
</div>
@endsection