@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div style="max-width: 500px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 12px;">
        <h1 style="margin-bottom: 1.5rem;">Inscription</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label>Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" style="width:100%; padding:0.8rem; border:1px solid #cbd5e1; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" style="width:100%; padding:0.8rem; border:1px solid #cbd5e1; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label>Mot de passe</label>
                <input type="password" name="password" style="width:100%; padding:0.8rem; border:1px solid #cbd5e1; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" style="width:100%; padding:0.8rem; border:1px solid #cbd5e1; border-radius:8px;">
            </div>

            <button type="submit" style="background:#4f46e5; color:white; border:none; padding:0.8rem 1.2rem; border-radius:8px;">
                S'inscrire
            </button>
        </form>
    </div>
@endsection