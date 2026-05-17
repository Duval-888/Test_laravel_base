<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background: #f0f4ff; }
        .container { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
            z-index: 100;
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
            color: #64748b;
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
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.2);
        }

        /* MAIN */
        .main { margin-left: 260px; flex: 1; padding: 28px; }

        /* TOPBAR */
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
        .topbar .admin-info {
            font-size: 14px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-avatar {
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

        /* ALERTS */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* BUTTONS */
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
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 12px rgba(99,102,241,0.4); }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 3px 8px rgba(239,68,68,0.3);
        }
        .btn-danger:hover { transform: translateY(-1px); }
        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 3px 8px rgba(16,185,129,0.3);
        }
        .btn-success:hover { transform: translateY(-1px); }

        /* CARDS */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-top: 4px solid;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.blue   { border-color: #3b82f6; }
        .stat-card.purple { border-color: #8b5cf6; }
        .stat-card.green  { border-color: #10b981; }
        .stat-card.orange { border-color: #f59e0b; }
        .stat-card h3 { font-size: 13px; color: #64748b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card p  { font-size: 32px; font-weight: 700; color: #0f172a; }
        .stat-card .icon { font-size: 28px; margin-bottom: 8px; }

        /* PANEL */
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

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; }
        th { padding: 12px 16px; text-align: left; font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        /* BADGE ROLE */
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .role-admin { background: #dbeafe; color: #1d4ed8; }
        .role-user  { background: #f1f5f9; color: #475569; }

        @media (max-width: 768px) {
            .sidebar { width: 220px; }
            .main { margin-left: 220px; }
        }
    </style>
    @yield('styles')
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <div class="logo">Admin<span>Forum</span></div>

        <div class="menu-title">Principal</div>
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Tableau de bord
                </a>
            </li>
        </ul>

        <div class="menu-title">Gestion du forum</div>
        <ul>
            <li>
                <a href="{{ route('admin.categories') }}"
                   class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    🗂️ Catégories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.topics') }}"
   class="{{ request()->routeIs('admin.topics') ? 'active' : '' }}">
    💬 Sujets
</a>
            </li>
            <li>
                <a href="{{ route('admin.moderation') }}"
                   class="{{ request()->routeIs('admin.moderation') ? 'active' : '' }}">
                    🛡️ Modération
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications') }}"
                   class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                    🔔 Notifications
                </a>
            </li>
        </ul>

        <div class="menu-title">Administration</div>
        <ul>
            <li>
                <a href="{{ route('admin.users') }}"
                   class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    👥 Utilisateurs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.roles') }}"
                   class="{{ request()->routeIs('admin.roles') ? 'active' : '' }}">
                    🎭 Rôles
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logs') }}"
                   class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                    📋 Logs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}"
                   class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    ⚙️ Configuration
                </a>
            </li>
        </ul>

        <li>
    <a href="{{ route('admin.notifications') }}"
       class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
        @php
            $adminUnread = \App\Models\Notification::where('user_id', auth()->id())
                ->where('is_read', false)->count();
        @endphp
        🔔 Notifications
        @if($adminUnread > 0)
            <span style="background:#ef4444; color:white; padding:2px 7px; border-radius:20px; font-size:11px; font-weight:bold; margin-left:auto;">
                {{ $adminUnread }}
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
            <h1>@yield('title', 'Administration')</h1>
            <div class="admin-info">
                <div class="admin-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:600; color:#0f172a;">{{ auth()->user()->name }}</div>
                    <div style="font-size:12px;">Administrateur</div>
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