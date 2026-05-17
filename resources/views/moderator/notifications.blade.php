@extends('layouts.moderator')

@section('title', 'Notifications')

@section('content')
<div class="panel">
    <h2>Mes notifications</h2>

    @forelse($notifications as $notification)
        <div style="padding:16px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;
                    {{ $notification->is_read ? '' : 'background:#f0f4ff; border-radius:10px; padding:16px;' }}">
            <div style="display:flex; gap:12px; align-items:flex-start;">
                <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#38bdf8); display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; flex-shrink:0;">
                    {{ strtoupper(substr($notification->fromUser->name ?? 'S', 0, 1)) }}
                </div>
                <div>
                    @if($notification->type === 'status_change')
                        <p style="margin:0; color:#1e293b; font-size:14px;">
                            <strong>{{ $notification->fromUser->name ?? 'Utilisateur' }}</strong>
                            a publié un nouveau sujet.
                        </p>
                    @elseif($notification->type === 'reply')
                        <p style="margin:0; color:#1e293b; font-size:14px;">
                            <strong>{{ $notification->fromUser->name ?? 'Utilisateur' }}</strong>
                            a répondu à un sujet.
                        </p>
                    @elseif($notification->type === 'likes')
                        <p style="margin:0; color:#1e293b; font-size:14px;">
                            <strong>{{ $notification->fromUser->name ?? 'Utilisateur' }}</strong>
                            a noté une réponse.
                        </p>
                    @endif
                    <p style="margin:4px 0 0; color:#94a3b8; font-size:12px;">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                @if(!$notification->is_read)
                    <span style="background:#dbeafe; color:#1d4ed8; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                        Nouveau
                    </span>
                @endif
                @if($notification->post_id && $notification->post)
                    <a href="{{ route('topics.show', $notification->post->topic_id) }}"
                       style="background:#6366f1; color:white; padding:6px 12px; border-radius:8px; font-size:13px; text-decoration:none; font-weight:600;">
                        Voir
                    </a>
                @endif
            </div>
        </div>
    @empty
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucune notification.</p>
    @endforelse

    <div style="margin-top:20px;">{{ $notifications->links() }}</div>
</div>

@if($notifications->where('is_read', false)->count() > 0)
    <form action="{{ route('moderator.notifications.readAll') }}" method="POST" style="margin-top:10px;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-primary">✅ Tout marquer comme lu</button>
    </form>
@endif
@endsection