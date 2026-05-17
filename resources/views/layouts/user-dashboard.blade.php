<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard utilisateur')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f8fafc; color: #1e293b; }
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar {
            width: 260px;
            background: #1e293b;
            color: white;
            padding: 1.5rem 1rem;
        }
        .sidebar h2 {
            margin-bottom: 2rem;
            font-size: 1.4rem;
        }
        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }
        .main {
            flex: 1;
            padding: 2rem;
        }
        .topbar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .card h3 {
            font-size: 2rem;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        .section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .section h2 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .item {
            padding: 0.8rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .item:last-child {
            border-bottom: none;
        }
        .btn {
            display: inline-block;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .btn-danger {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Espace utilisateur</h2>

            <a href="{{ route('user.dashboard') }}">Tableau de bord</a>
            <a href="{{ route('topics.create') }}">Poser une question</a>
            <a href="{{ route('topics.index') }}">Voir les questions</a>
            <a href="{{ route('categories.index') }}">Catégories</a>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: 1rem;">
                @csrf
                <button type="submit" class="btn btn-danger" style="width:100%;">Déconnexion</button>
            </form>
        </aside>

        <main class="main">
            <div class="topbar">
                <div>
                    <strong>Bienvenue, {{ auth()->user()->name }}</strong>
                    <div style="font-size: 0.9rem; color: #64748b;">Rôle : {{ auth()->user()->role }}</div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>
</body>
</html>