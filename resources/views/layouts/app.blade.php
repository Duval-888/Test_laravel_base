<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Forum en Ligne')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Figtree, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .navbar {
            background: #1e293b;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            transition: color 0.2s;
        }

        .navbar-brand:hover {
            color: #e2e8f0;
            text-decoration: none;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
            display: inline-block;
            position: relative;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            text-decoration: none;
        }

        .btn-auth {
            background: #667eea;
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(102,126,234,0.2);
            display: inline-block;
        }

        .btn-auth:hover {
            background: #5a67d8;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102,126,234,0.3);
            text-decoration: none;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            box-shadow: 0 2px 4px rgba(220,38,38,0.2);
        }

        .btn-danger:hover {
            background: #b91c1c;
            box-shadow: 0 4px 8px rgba(220,38,38,0.3);
        }

        .btn-moderator {
            background: #059669;
            box-shadow: 0 2px 4px rgba(5,150,105,0.2);
        }

        .btn-moderator:hover {
            background: #047857;
            box-shadow: 0 4px 8px rgba(5,150,105,0.3);
        }

        .logout-form {
            margin: 0;
            display: inline;
        }

        .notif-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #dc2626;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 20px;
            min-width: 18px;
            text-align: center;
            line-height: 1.4;
        }

        .page-content {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .footer {
            margin-top: 3rem;
            padding: 2rem 0;
            text-align: center;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            background: #fff;
        }

        @media (max-width: 768px) {
            .navbar .container {
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar-nav { width: 100%; }
        }

        @yield('styles')
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Forum en Ligne</a>

            <ul class="navbar-nav">
                <li><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                <li><a class="nav-link" href="{{ route('categories.index') }}">Catégories</a></li>
                <li><a class="nav-link" href="{{ route('topics.index') }}">Sujets</a></li>

                @guest
                    <li><a class="btn-auth" href="{{ route('login') }}">Connexion</a></li>
                    <li><a class="btn-auth" href="{{ route('register') }}">Inscription</a></li>
                @endguest

                @auth
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    @if(auth()->user()->role === 'admin')
                        <li><a class="btn-auth" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                    @elseif(auth()->user()->role === 'moderator')
                        <li><a class="btn-auth btn-moderator" href="{{ route('moderator.dashboard') }}">Dashboard Modérateur</a></li>
                    @else
                        <li><a class="btn-auth" href="{{ route('user.dashboard') }}">Mon dashboard</a></li>
                    @endif

                    <li><a class="btn-auth" href="{{ route('topics.create') }}">Nouveau sujet</a></li>

                    <li>
                        <a class="nav-link" href="{{ auth()->user()->role === 'admin' ? route('admin.notifications') : route('user.dashboard') }}">
                            🔔
                            @if($unreadCount > 0)
                                <span class="notif-badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li><span class="nav-link">Bienvenue, {{ auth()->user()->name }}</span></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn-auth btn-danger">Déconnexion</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container page-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Forum en Ligne - Projet Laravel</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>