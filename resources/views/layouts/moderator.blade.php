<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Modération')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background: #f0f4ff; }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
            z-index: 100;
            flex-shrink: 0;
        }

        .sidebar .logo {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            padding: 28px 20px;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            letter-spacing: 1px;
        }
        .sidebar .logo span { color: #38bdf8; }

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 20px 20px 8px;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .sidebar ul { list-style: none; padding: 0 10px; }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #94a3b8;
            text-decoration: none;
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 3px;
            transition: all 0.2s;
            font-size: 14.5px;
        }
        .sidebar ul li a:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }
        .sidebar ul li a.active {
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: auto;
        }

        .main {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 16px 24px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 24px;
            border-left: 4px solid #6366f1;
        }
        .topbar h1 { font-size: 20px; color: #0f172a; font-weight: 700; }
        .topbar .mod-info {
            font-size: 14px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mod-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 15px;
        }

        .alert { padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

        .btn {
            display: inline-block;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 3px 8px rgba(99,102,241,0.3);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 3px 8px rgba(239,68,68,0.3);
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 3px 8px rgba(245,158,11,0.3);
        }
        .btn:hover { transform: translateY(-1px); }

        .panel {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }
        .panel h2 {
            font-size: 17px;
            color: #0f172a;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
            font-weight: 700;
        }

        table { width: 100%; border-collapse: collapse; }
        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            background: #f8fafc;
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #334155;
        }
        tr:hover td { background: #f8fafc; }
    </style>
    @yield('styles')
</head>
<body>
<div class="wrapper">
    <aside class="sidebar">
        <div class="logo">Modo<span>Forum</span></div>

        <div class="menu-title">Modération</div>
        <ul>
            <li>
                <a href="{{ route('moderator.dashboard') }}"
                   class="{{ request()->routeIs('moderator.dashboard') ? 'active' : '' }}">
                    📊 Tableau de bord
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.posts') }}"
                   class="{{ request()->routeIs('moderator.posts') ? 'active' : '' }}">
                    🛡️ Posts signalés
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.topics') }}"
                   class="{{ request()->routeIs('moderator.topics') ? 'active' : '' }}">
                    💬 Sujets
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.logs') }}"
                   class="{{ request()->routeIs('moderator.logs') ? 'active' : '' }}">
                    📋 Mes logs
                </a>
            </li>
        </ul>

       <div class="menu-title">Navigation</div>
<ul>
    <li>
        <a href="{{ route('home') }}">🏠 Accueil forum</a>
    </li>
    <li>
        <a href="{{ route('moderator.topics') }}"
           class="{{ request()->routeIs('moderator.topics') ? 'active' : '' }}">
            📝 Tous les sujets
        </a>
    </li>
</ul>

<li>
    <a href="{{ route('moderator.notifications') }}"
       class="{{ request()->routeIs('moderator.notifications') ? 'active' : '' }}">
        @php
            $modUnread = \App\Models\Notification::where('user_id', auth()->id())
                ->where('is_read', false)->count();
        @endphp
        🔔 Notifications
        @if($modUnread > 0)
            <span style="background:#ef4444; color:white; padding:2px 7px; border-radius:20px; font-size:11px; font-weight:bold; margin-left:auto;">
                {{ $modUnread }}
            </span>
        @endif
    </a>
</li>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="width:100%;">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <h1>@yield('title', 'Modération')</h1>
            <div class="mod-info">
                <div class="mod-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:600; color:#0f172a;">{{ auth()->user()->name }}</div>
                    <div style="font-size:12px;">Modérateur</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>
@yield('scripts')
</body>
</html>