@extends('layouts.app')

@section('title', 'Voir les questions')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <h1>Liste des questions</h1>

        @auth
            <a href="{{ route('topics.create') }}" class="btn-auth">Poser une question</a>
        @endauth
    </div>

    @forelse($topics as $topic)
        <div style="background:white; padding:1.5rem; border-radius:12px; margin-bottom:1rem;">
            <h3 style="margin-bottom:0.75rem;">
                <a href="{{ route('topics.show', $topic->id) }}" style="text-decoration:none; color:#1e293b;">
                    {{ $topic->title }}
                </a>
            </h3>

            <p style="margin:0; font-size:1.05rem; color:#1e293b;">
                {{ $topic->content }}
            </p>

            <p style="margin-top:0.75rem; color:#64748b; font-size:0.9rem;">
                Catégorie : {{ $topic->category->name ?? 'Aucune' }} <br>
                Par {{ $topic->user->name ?? 'Utilisateur' }}
                • {{ $topic->created_at->diffForHumans() }}
            </p>

            <div style="margin-top:1rem; display:flex; gap:0.75rem; flex-wrap:wrap;">
                <a href="{{ route('topics.show', $topic->id) }}" class="btn-auth">
                    Voir les réponses
                </a>

                @auth
                    <a href="{{ route('topics.show', $topic->id) }}#reply-form" class="btn-auth" style="background:#0f766e;">
                        Ajouter une réponse
                    </a>
                @endauth
            </div>
        </div>
    @empty
        <div style="background:white; padding:1.5rem; border-radius:12px;">
            Aucun message pour le moment.
        </div>
    @endforelse
@endsection