@extends('layouts.user-dashboard')

@section('title', 'Dashboard utilisateur')

@section('content')
    <div class="cards">
        <div class="card">
            <h3>{{ $stats['topics_count'] }}</h3>
            <p>Questions posées</p>
        </div>

        <div class="card">
            <h3>{{ $stats['posts_count'] }}</h3>
            <p>Réponses / commentaires</p>
        </div>

        <div class="card">
            <h3>{{ $stats['votes_count'] }}</h3>
            <p>Votes effectués</p>
        </div>
    </div>

    <div class="section">
        <h2>Actions rapides</h2>
        <a href="{{ route('topics.create') }}" class="btn">Poser une question</a>
        <a href="{{ route('topics.index') }}" class="btn" style="margin-left: 10px;">Voir les discussions</a>
    </div>

    <div class="section">
        <h2>Mes dernières questions</h2>

        @forelse($latestTopics as $topic)
            <div class="item">
                <a href="{{ route('topics.show', $topic->id) }}" style="text-decoration:none; color:#1e293b;">
                    {{ $topic->title }}
                </a>
            </div>
        @empty
            <p>Aucune question publiée pour le moment.</p>
        @endforelse
    </div>

    <div class="section">
        <h2>Mes derniers commentaires</h2>

        @forelse($latestPosts as $post)
            <div class="item">
                {{ \Illuminate\Support\Str::limit($post->content, 120) }}
            </div>
        @empty
            <p>Aucun commentaire publié pour le moment.</p>
        @endforelse
    </div>
@endsection