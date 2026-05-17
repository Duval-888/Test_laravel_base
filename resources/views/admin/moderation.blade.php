@extends('layouts.admin')

@section('title', 'Modération des contenus')

@section('content')
<div style="background:white; padding:24px; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom:20px; color:#0f172a;">Posts signalés / non approuvés</h2>

    @forelse($posts as $post)
        <div style="border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:16px;">
            <p style="color:#1e293b; margin-bottom:8px;">{{ $post->content }}</p>
            <p style="color:#64748b; font-size:0.9rem;">
                Par <strong>{{ $post->user->name ?? 'Utilisateur' }}</strong>
                dans <strong>{{ $post->topic->title ?? 'Sujet supprimé' }}</strong>
                • {{ $post->created_at->diffForHumans() }}
            </p>
            <div style="margin-top:12px; display:flex; gap:10px;">
                <form action="{{ route('admin.moderation.restore', $post->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="reason" value="Approuvé par l'administrateur">
                    <button type="submit" class="btn btn-success">Approuver</button>
                </form>
            </div>
        </div>
    @empty
        <p style="color:#64748b;">Aucun contenu à modérer.</p>
    @endforelse

    <div style="margin-top:20px;">{{ $posts->links() }}</div>
</div>
@endsection