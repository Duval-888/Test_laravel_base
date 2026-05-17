@extends('layouts.admin')

@section('title', 'Gestion des sujets')

@section('content')
<div class="panel">
    <h2>Liste des sujets</h2>

    @forelse($topics as $topic)
        <div style="padding:16px 0; border-bottom:1px solid #f1f5f9;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                <div>
                    <a href="{{ route('topics.show', $topic->id) }}"
                       style="font-weight:600; color:#0f172a; text-decoration:none; font-size:15px;">
                        {{ $topic->title }}
                    </a>
                    <div style="font-size:13px; color:#64748b; margin-top:4px;">
                        Par <strong>{{ $topic->user->name ?? 'Utilisateur' }}</strong>
                        dans <strong>{{ $topic->category->name ?? 'Aucune' }}</strong>
                        • {{ $topic->created_at->diffForHumans() }}
                        • {{ $topic->posts_count }} réponse(s)
                    </div>
                </div>
                <div style="display:flex; gap:8px; align-items:center;">
                    @if($topic->is_locked)
                        <span style="background:#fee2e2; color:#dc2626; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                            🔒 Verrouillé
                        </span>
                    @else
                        <span style="background:#d1fae5; color:#065f46; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                            ✅ Actif
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucun sujet disponible.</p>
    @endforelse

    <div style="margin-top:20px;">{{ $topics->links() }}</div>
</div>
@endsection