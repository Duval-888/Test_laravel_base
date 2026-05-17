<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-container {
            background: white;
            width: 100%;
            max-width: 430px;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #0f172a;
        }

        .login-container p {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334155;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #38bdf8;
        }

        .btn {
            width: 100%;
            background: #1e293b;
            color: white;
            border: none;
            padding: 13px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn:hover {
            background: #334155;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .register-link {
            text-align: center;
            margin-top: 18px;
        }

        .register-link a {
            color: #0f172a;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <p>Choisissez votre type de connexion</p>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                <ul style="margin-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="login_as">Se connecter en tant que</label>
                <select name="login_as" id="login_as" required>
    <option value="">-- Choisir un rôle --</option>
    <option value="user"      {{ old('login_as') == 'user'      ? 'selected' : '' }}>Utilisateur</option>
    <option value="moderator" {{ old('login_as') == 'moderator' ? 'selected' : '' }}>Modérateur</option>
    <option value="admin"     {{ old('login_as') == 'admin'     ? 'selected' : '' }}>Administrateur</option>
</select>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn">Se connecter</button>
        </form>

        <div class="register-link">
            <p>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>