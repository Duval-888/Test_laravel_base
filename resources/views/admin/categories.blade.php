@extends('layouts.admin')

@section('title', 'Gestion des catégories')

@section('content')
<div class="panel" style="margin-bottom:24px;">
    <h2>Ajouter une catégorie</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">
                    Nom de la catégorie
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: Laravel"
                    style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:10px; outline:none; font-size:14px;"
                    required
                >
                @error('name')
                    <p style="color:#dc2626; margin-top:6px; font-size:13px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">
                    Description
                </label>
                <textarea
                    name="description"
                    rows="3"
                    placeholder="Petite description de la catégorie"
                    style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:10px; outline:none; resize:none; font-size:14px;"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p style="color:#dc2626; margin-top:6px; font-size:13px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">
                ➕ Ajouter la catégorie
            </button>
        </div>
    </form>
</div>

<div class="panel">
    <h2>Liste des catégories</h2>

    @if($categories->count() > 0)
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">
            @foreach($categories as $category)
                <div style="background:#f8fafc; border-radius:12px; padding:20px; border:1px solid #e2e8f0; transition:all 0.2s;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                        <h3 style="margin:0; color:#0f172a; font-size:16px;">{{ $category->name }}</h3>
                        <span style="background:#dbeafe; color:#1d4ed8; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                            {{ $category->topics_count ?? 0 }} sujet(s)
                        </span>
                    </div>

                    <p style="color:#64748b; font-size:14px; min-height:40px; margin-bottom:12px;">
                        {{ $category->description ?: 'Aucune description.' }}
                    </p>

                    <div style="font-size:12px; color:#94a3b8; margin-bottom:14px;">
                        📅 Créée le {{ $category->created_at->format('d/m/Y à H:i') }}
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:8px 14px; font-size:13px;">
                                🗑️ Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucune catégorie disponible.</p>
    @endif
</div>
@endsection