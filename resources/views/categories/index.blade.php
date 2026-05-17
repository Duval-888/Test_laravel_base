@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
<h1 style="margin-bottom:1.5rem;">Catégories</h1>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:1rem;">
    @forelse($categories as $category)
        <a href="{{ route('categories.show', $category->id) }}"
           style="background:white; padding:1.5rem; border-radius:12px; text-decoration:none; color:#1e293b;">
            <h3 style="margin-bottom:0.5rem;">{{ $category->name }}</h3>
            <p style="color:#64748b; margin-bottom:0.5rem;">
                {{ $category->description ?? 'Aucune description' }}
            </p>
            <p style="color:#64748b;">{{ $category->topics_count }} sujet(s)</p>
        </a>
    @empty
        <div style="background:white; padding:1.5rem; border-radius:12px;">
            Aucune catégorie disponible.
        </div>
    @endforelse
</div>
@endsection