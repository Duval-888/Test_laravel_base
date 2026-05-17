@extends('layouts.app')

@section('title', 'Forum en Ligne - Accueil')

@section('styles')
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
        margin-bottom: 3rem;
        border-radius: 0 0 1.5rem 1.5rem;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-section p {
        font-size: 1.25rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto 2rem auto;
    }

    .hero-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-button {
        display: inline-block;
        padding: 0.9rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .hero-button-primary {
        background: white;
        color: #4f46e5;
    }

    .hero-button-primary:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .hero-button-secondary {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .hero-button-secondary:hover {
        background: rgba(255, 255, 255, 0.22);
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
        display: block;
    }

    .stat-label {
        color: #64748b;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .section {
        margin-bottom: 4rem;
    }

    .section h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        text-align: center;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
    }

    .category-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .category-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
        display: block;
    }

    .category-description {
        color: #64748b;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .category-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        color: #94a3b8;
        font-weight: 500;
        flex-wrap: wrap;
    }

    .topics-list {
        display: grid;
        gap: 1rem;
    }

    .topic-item {
        background: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        color: inherit;
    }

    .topic-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .topic-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .topic-meta {
        font-size: 0.9rem;
        color: #64748b;
    }

    .api-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 3rem;
        border-radius: 1rem;
        text-align: center;
        border: 1px solid #cbd5e1;
    }

    .api-section h3 {
        color: #1e293b;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .api-section p {
        color: #64748b;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .api-button {
        display: inline-block;
        background: #667eea;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
    }

    .api-button:hover {
        background: #5a67d8;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
        text-decoration: none;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #64748b;
        background: white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
    }

    .empty-state h3 {
        color: #1e293b;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.2rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .category-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
@endsection

@section('content')
<div class="hero-section">
    <div class="container">
        <h1>Forum en Ligne</h1>
        <p>Plateforme de discussion communautaire avec système de votes, badges, modération et notifications.</p>

        <div class="hero-actions">
            @if (Route::has('topics.index'))
                <a href="{{ route('topics.index') }}" class="hero-button hero-button-primary">Voir les sujets</a>
            @endif

            @auth
                @if (Route::has('topics.create'))
                    <a href="{{ route('topics.create') }}" class="hero-button hero-button-secondary">Créer un sujet</a>
                @endif
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hero-button hero-button-secondary">Créer un compte</a>
                @endif
            @endauth
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-number">{{ $stats['total_topics'] ?? 0 }}</span>
        <span class="stat-label">Sujets</span>
    </div>

    <div class="stat-card">
        <span class="stat-number">{{ $stats['total_posts'] ?? 0 }}</span>
        <span class="stat-label">Messages</span>
    </div>

    <div class="stat-card">
        <span class="stat-number">{{ $stats['total_users'] ?? 0 }}</span>
        <span class="stat-label">Utilisateurs</span>
    </div>

    <div class="stat-card">
        <span class="stat-number">{{ $categories->count() }}</span>
        <span class="stat-label">Catégories</span>
    </div>
</div>

<div class="section">
    <h2>Catégories</h2>

    <div class="categories-grid">
        @forelse($categories as $category)
            <a
                href="{{ Route::has('categories.show') ? route('categories.show', $category->id) : '#' }}"
                class="category-card"
            >
                <span class="category-name">{{ $category->name }}</span>
                <p class="category-description">{{ $category->description ?? 'Aucune description disponible' }}</p>

                <div class="category-meta">
                    <span>{{ $category->topics_count ?? 0 }} sujet(s)</span>
                    <span>
                        Dernière activité :
                        {{ $category->updated_at ? $category->updated_at->diffForHumans() : 'Aucune activité' }}
                    </span>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <h3>Aucune catégorie</h3>
                <p>Les catégories seront affichées ici une fois créées.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="section">
    <h2>Sujets récents</h2>

    <div class="topics-list">
        @forelse($recentTopics as $topic)
            <a
                href="{{ Route::has('topics.show') ? route('topics.show', $topic->id) : '#' }}"
                class="topic-item"
            >
                <div class="topic-title">{{ $topic->title }}</div>

                <div class="topic-meta">
                    Par {{ $topic->user->name ?? 'Utilisateur inconnu' }}
                    dans {{ $topic->category->name ?? 'Catégorie inconnue' }}
                    • {{ $topic->created_at ? $topic->created_at->diffForHumans() : 'Date inconnue' }}
                    • {{ $topic->posts_count ?? 0 }} réponse(s)
                </div>
            </a>
        @empty
            <div class="empty-state">
                <h3>Aucun sujet récent</h3>
                <p>Les sujets récents apparaîtront ici.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="api-section">
    <h3>Plateforme prête à être utilisée</h3>
    <p>Explore les catégories, consulte les sujets récents et participe aux discussions de la communauté.</p>

    @if (Route::has('categories.index'))
        <a href="{{ route('categories.index') }}" class="api-button">Explorer les catégories</a>
    @elseif (Route::has('topics.index'))
        <a href="{{ route('topics.index') }}" class="api-button">Explorer les sujets</a>
    @endif
</div>
@endsection