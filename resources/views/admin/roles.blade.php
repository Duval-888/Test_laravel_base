@extends('layouts.admin')

@section('title', 'Attribution des rôles')

@section('content')
<div style="background:white; padding:24px; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom:20px; color:#0f172a;">Attribution des rôles</h2>

    @foreach($users as $user)
    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0; border-bottom:1px solid #e2e8f0; flex-wrap:wrap; gap:10px;">
        <div>
            <strong>{{ $user->name }}</strong>
            <span style="color:#64748b; font-size:0.9rem;"> — {{ $user->email }}</span>
        </div>
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" style="display:flex; gap:8px;">
            @csrf
            @method('PATCH')
            <select name="role" style="padding:8px; border:1px solid #cbd5e1; border-radius:8px;">
                <option value="user"  {{ $user->role === 'user'  ? 'selected' : '' }}>Utilisateur</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
            <button type="submit" class="btn btn-primary">Appliquer</button>
        </form>
    </div>
    @endforeach
</div>
@endsection