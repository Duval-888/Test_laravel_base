@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div style="background:white; padding:2rem; border-radius:12px; margin-bottom:2rem;">
    <h1>{{ $category->name }}</h1>
    <p style="color:#64748b;">{{ $category->description ?? 'Aucune description' }}</p>
</div>

<h2 style="margin-bottom:1rem;">Questions dans cette catégorie</h2>

@forelse($category->topics as $topic)
    <div style="background:white; padding:1.5rem; border-radius:12px; margin-bottom:1rem;">
        <h3>
            <a href="{{ route('topics.show', $topic->id) }}" style="text-decoration:none; color:#1e293b;">
                {{ $topic->title }}
            </a>
        </h3>
        <p style="color:#64748b;">
            Par {{ $topic->user->name ?? 'Utilisateur' }} • {{ $topic->created_at->diffForHumans() }}
        </p>
    </div>
@empty
    <div style="background:white; padding:1.5rem; border-radius:12px;">
        Aucun sujet dans cette catégorie.
    </div>
@endforelse
@endsection