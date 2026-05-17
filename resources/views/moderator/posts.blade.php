@extends('layouts.moderator')

@section('title', 'Posts signalés')

@section('content')
<div class="panel">
    <h2>Posts non approuvés</h2>

    @forelse($posts as $post)
        <div style="border:1px solid #e2e8f0; border-radius:12px; padding:18px; margin-bottom:16px;">
            <p style="color:#1e293b; margin-bottom:10px; line-height:1.6;">{{ $post->content }}</p>
            <p style="color:#64748b; font-size:13px; margin-bottom:14px;">
                Par <strong>{{ $post->user->name ?? 'Utilisateur' }}</strong>
                dans <strong>{{ $post->topic->title ?? 'Sujet supprimé' }}</strong>
                • {{ $post->created_at->diffForHumans() }}
            </p>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <form action="{{ route('moderator.posts.restore', $post->id) }}" method="POST" style="display:flex; gap:8px; align-items:center;">
                    @csrf @method('PATCH')
                    <input type="text" name="reason" placeholder="Raison..." required
                           style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; width:200px;">
                    <button type="submit" class="btn btn-primary">✅ Approuver</button>
                </form>

                <form action="{{ route('moderator.posts.delete', $post->id) }}" method="POST" style="display:flex; gap:8px; align-items:center;">
                    @csrf @method('PATCH')
                    <input type="text" name="reason" placeholder="Raison..." required
                           style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; width:200px;">
                    <button type="submit" class="btn btn-danger">🗑️ Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucun post à modérer.</p>
    @endforelse

    <div style="margin-top:20px;">{{ $posts->links() }}</div>
</div>
@endsection