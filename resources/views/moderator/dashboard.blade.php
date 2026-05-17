@extends('layouts.moderator')

@section('title', 'Tableau de bord Modérateur')

@section('content')
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:24px;">
    <div style="background:white; border-radius:14px; padding:22px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border-top:4px solid #ef4444;">
        <div style="font-size:28px; margin-bottom:8px;">🚨</div>
        <h3 style="color:#64748b; font-size:13px; text-transform:uppercase; margin-bottom:8px;">Posts signalés</h3>
        <p style="font-size:32px; font-weight:700; color:#0f172a;">{{ $stats['posts_signales'] }}</p>
    </div>
    <div style="background:white; border-radius:14px; padding:22px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border-top:4px solid #3b82f6;">
        <div style="font-size:28px; margin-bottom:8px;">💬</div>
        <h3 style="color:#64748b; font-size:13px; text-transform:uppercase; margin-bottom:8px;">Total sujets</h3>
        <p style="font-size:32px; font-weight:700; color:#0f172a;">{{ $stats['topics_count'] }}</p>
    </div>
    <div style="background:white; border-radius:14px; padding:22px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border-top:4px solid #f59e0b;">
        <div style="font-size:28px; margin-bottom:8px;">🔒</div>
        <h3 style="color:#64748b; font-size:13px; text-transform:uppercase; margin-bottom:8px;">Sujets verrouillés</h3>
        <p style="font-size:32px; font-weight:700; color:#0f172a;">{{ $stats['topics_lockés'] }}</p>
    </div>
    <div style="background:white; border-radius:14px; padding:22px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border-top:4px solid #10b981;">
        <div style="font-size:28px; margin-bottom:8px;">✅</div>
        <h3 style="color:#64748b; font-size:13px; text-transform:uppercase; margin-bottom:8px;">Mes actions</h3>
        <p style="font-size:32px; font-weight:700; color:#0f172a;">{{ $stats['mes_actions'] }}</p>
    </div>
</div>

<div class="panel">
    <h2>Mes dernières actions</h2>
    @forelse($recentLogs as $log)
        <div style="padding:14px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div>
                <span style="background:#d1fae5; color:#065f46; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                    {{ $log->action }}
                </span>
                <span style="color:#64748b; font-size:14px; margin-left:10px;">{{ $log->reason }}</span>
            </div>
            <span style="color:#94a3b8; font-size:13px;">{{ $log->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <p style="color:#94a3b8; text-align:center; padding:20px;">Aucune action effectuée.</p>
    @endforelse
</div>
@endsection