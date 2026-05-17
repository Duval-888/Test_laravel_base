@extends('layouts.admin')

@section('title', 'Logs et statistiques')

@section('content')
<div style="background:white; padding:24px; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom:20px; color:#0f172a;">Logs de modération</h2>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="padding:12px; text-align:left;">Modérateur</th>
                <th style="padding:12px; text-align:left;">Action</th>
                <th style="padding:12px; text-align:left;">Raison</th>
                <th style="padding:12px; text-align:left;">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:12px;">{{ $log->moderator->name ?? 'Système' }}</td>
                <td style="padding:12px;">
                    <span style="background:#dbeafe; color:#1d4ed8; padding:4px 10px; border-radius:20px; font-size:13px;">
                        {{ $log->action }}
                    </span>
                </td>
                <td style="padding:12px;">{{ $log->reason }}</td>
                <td style="padding:12px;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:20px; text-align:center; color:#64748b;">
                    Aucun log disponible.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">{{ $logs->links() }}</div>
</div>
@endsection