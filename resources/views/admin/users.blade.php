@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div style="background:white; padding:24px; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom:20px; color:#0f172a;">Liste des utilisateurs</h2>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="padding:12px; text-align:left;">#</th>
                <th style="padding:12px; text-align:left;">Nom</th>
                <th style="padding:12px; text-align:left;">Email</th>
                <th style="padding:12px; text-align:left;">Rôle</th>
                <th style="padding:12px; text-align:left;">Inscrit le</th>
                <th style="padding:12px; text-align:left;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:12px;">{{ $user->id }}</td>
                <td style="padding:12px;">{{ $user->name }}</td>
                <td style="padding:12px;">{{ $user->email }}</td>
                <td style="padding:12px;">
                    <span style="background:{{ $user->role === 'admin' ? '#dbeafe' : '#f1f5f9' }};
                                 color:{{ $user->role === 'admin' ? '#1d4ed8' : '#475569' }};
                                 padding:4px 10px; border-radius:20px; font-size:13px;">
                        {{ $user->role }}
                    </span>
                </td>
                <td style="padding:12px;">{{ $user->created_at->format('d/m/Y') }}</td>
                <td style="padding:12px;">
                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" style="display:flex; gap:8px;">
                        @csrf
                        @method('PATCH')
                        <select name="role" style="padding:6px; border:1px solid #cbd5e1; border-radius:8px;">
                            <option value="user"  {{ $user->role === 'user'  ? 'selected' : '' }}>user</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;">
                            Mettre à jour
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection