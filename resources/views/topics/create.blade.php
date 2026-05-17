@extends('layouts.app')

@section('title', 'Poser une question')

@section('content')
<div style="background:white; padding:2rem; border-radius:12px;">
    <h1 style="margin-bottom:1.5rem;">Poser une question</h1>

    <form method="POST" action="{{ route('topics.store') }}">
        @csrf

        <div style="margin-bottom:1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:bold;">
                Choisir une catégorie
            </label>
            <select name="category_id"
                style="width:100%; padding:1rem; border:1px solid #cbd5e1; border-radius:8px;">
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:bold;">
                Titre de la question
            </label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Exemple : Qu'est-ce qu'un algorithme ?"
                style="width:100%; padding:1rem; border:1px solid #cbd5e1; border-radius:8px;"
            >
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:bold;">
                Écris ton message
            </label>
            <textarea
                name="content"
                rows="8"
                placeholder="Écris ta question ici..."
                style="width:100%; padding:1rem; border:1px solid #cbd5e1; border-radius:8px;"
            >{{ old('content') }}</textarea>
        </div>

        <button type="submit"
            style="background:#4f46e5; color:white; border:none; padding:0.8rem 1.2rem; border-radius:8px; cursor:pointer; font-weight:bold;">
            Envoyer
        </button>
    </form>
</div>
@endsection