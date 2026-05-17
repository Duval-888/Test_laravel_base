@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<style>
.rating-stars {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: 0.15rem;
}
.rating-stars input {
    display: none;
}
.rating-stars label {
    font-size: 1.6rem;
    color: #cbd5e1;
    cursor: pointer;
    transition: color 0.2s ease;
}
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #f59e0b;
}
.rating-stars input:checked ~ label {
    color: #f59e0b;
}
.reply-btn {
    background: #4f46e5;
    color: white;
    border: none;
    padding: 0.7rem 1.1rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}
.reply-btn:hover {
    background: #4338ca;
}
</style>

{{-- Sujet --}}
<div style="background:white; padding:2rem; border-radius:12px; margin-bottom:2rem;">
<h1 style="margin-bottom:1rem;">{{ $topic->title }}</h1>

<p style="font-size:1.05rem; color:#1e293b; margin-bottom:1rem; line-height:1.7;">
    {{ $topic->content }}
</p>

<p style="color:#64748b; margin:0;">
    Catégorie : {{ $topic->category->name ?? 'Aucune' }} <br>
    Par {{ $topic->user->name ?? 'Utilisateur' }}
    • {{ $topic->created_at->diffForHumans() }}
    • 👁️ {{ $topic->views_count }} vue(s)
</p>

@if($topic->is_locked)
    <div style="margin-top:1rem; background:#fee2e2; color:#991b1b; padding:0.75rem 1rem; border-radius:8px; font-size:0.9rem;">
        🔒 Ce sujet est verrouillé — les nouvelles réponses sont désactivées.
    </div>
@endif
</div>

{{-- Réponses --}}
<div style="background:white; padding:2rem; border-radius:12px; margin-bottom:2rem;">
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
    <h2 style="margin:0;">Réponses</h2>
    <span style="color:#64748b;">{{ $topic->posts->count() }} réponse(s)</span>
</div>

@forelse($topic->posts as $post)
    <div style="border:1px solid #e2e8f0; border-radius:10px; padding:1rem; margin-bottom:1rem;">

        <p style="margin-bottom:0.75rem; color:#1e293b; line-height:1.7;">
            {{ $post->content }}
        </p>

        <p style="font-size:0.9rem; color:#64748b; margin-bottom:0.5rem;">
            Réponse de <strong>{{ $post->user->name ?? 'Utilisateur' }}</strong>
            • {{ $post->created_at->diffForHumans() }}
        </p>

        <p style="font-size:1.2rem; color:#f59e0b; margin-bottom:0.35rem;">
            {{ $post->stars() }}
        </p>

        <p style="font-size:0.9rem; color:#64748b; margin-bottom:0.9rem;">
            Moyenne : {{ $post->averageRating() }}/5
            • {{ $post->ratingsCount() }} vote(s)
        </p>

        @auth
            @if($post->user_id !== auth()->id())
                <form method="POST" action="{{ route('posts.vote', $post->id) }}">
                    @csrf
                    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                        <span style="font-weight:600;">Noter cette réponse :</span>
                        <div class="rating-stars">
                            <input type="radio" id="star5-{{ $post->id }}" name="value" value="5">
                            <label for="star5-{{ $post->id }}">★</label>
                            <input type="radio" id="star4-{{ $post->id }}" name="value" value="4">
                            <label for="star4-{{ $post->id }}">★</label>
                            <input type="radio" id="star3-{{ $post->id }}" name="value" value="3">
                            <label for="star3-{{ $post->id }}">★</label>
                            <input type="radio" id="star2-{{ $post->id }}" name="value" value="2">
                            <label for="star2-{{ $post->id }}">★</label>
                            <input type="radio" id="star1-{{ $post->id }}" name="value" value="1" checked>
                            <label for="star1-{{ $post->id }}">★</label>
                        </div>
                        <button type="submit" class="reply-btn">Noter</button>
                    </div>
                </form>
            @else
                <p style="color:#64748b; font-size:0.9rem; margin:0;">
                    Tu ne peux pas noter ta propre réponse.
                </p>
            @endif
        @endauth
    </div>
@empty
    <div style="padding:1rem; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; color:#64748b;">
        Aucune réponse pour le moment.
    </div>
@endforelse
</div>

{{-- Formulaire de réponse --}}
@auth
@if(!$topic->is_locked)
    <div id="reply-form" style="background:white; padding:2rem; border-radius:12px;">
        <h2 style="margin-bottom:1rem;">Ajouter une réponse</h2>
        <form method="POST" action="{{ route('posts.store', $topic->id) }}">
            @csrf
            <textarea
                name="content"
                rows="5"
                style="width:100%; padding:0.8rem; border:1px solid #cbd5e1; border-radius:8px; margin-bottom:1rem; font-size:1rem;"
                placeholder="Écris ta réponse ici..."
            >{{ old('content') }}</textarea>
            <button type="submit" class="reply-btn">Ajouter une réponse</button>
        </form>
    </div>
@else
    <div style="background:white; padding:1.5rem; border-radius:12px; text-align:center; color:#64748b;">
        🔒 Ce sujet est verrouillé, vous ne pouvez plus répondre.
    </div>
@endif
@endauth

@endsection