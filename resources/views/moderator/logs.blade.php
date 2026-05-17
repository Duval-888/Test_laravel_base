@extends('layouts.moderator')

@section('title', 'Mes logs de modération')

@section('content')
<div class="panel">
    <h2>Mes actions de modération</h2>

    <table>
        <thead>
            <tr>
                <th>Action</th>
                <th>Raison</th>
                <th>Cible</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td>
                    <span style="background:#d1fae5; color:#065f46; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                        {{ $log->action }}
                    </span>
                </td>
                <td>{{ $log->reason }}</td>
                <td>
                    @if($log->post)
                        Post #{{ $log->post_id }}
                    @elseif($log->topic)
                        Sujet : {{ $log->topic->title }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#94a3b8; padding:20px;">
                    Aucune action effectuée.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">{{ $logs->links() }}</div>
</div>
@endsection