<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user', // inscription normale = utilisateur
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès. Connectez-vous.');
    }

   public function login(Request $request)
{
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
        'login_as' => ['required', 'in:user,admin,moderator'],
    ]);

    $credentials = [
        'email'    => $request->email,
        'password' => $request->password,
    ];

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput();
    }

    $request->session()->regenerate();
    $user = Auth::user();

    // Vérifier que le rôle choisi correspond au rôle réel
    if ($request->login_as === 'admin' && $user->role !== 'admin') {
        Auth::logout();
        return back()->withErrors([
            'login_as' => 'Ce compte n\'est pas un compte administrateur.',
        ])->withInput();
    }

    if ($request->login_as === 'moderator' && $user->role !== 'moderator') {
        Auth::logout();
        return back()->withErrors([
            'login_as' => 'Ce compte n\'est pas un compte modérateur.',
        ])->withInput();
    }

    if ($request->login_as === 'user' && !in_array($user->role, ['user', 'admin', 'moderator'])) {
        Auth::logout();
        return back()->withErrors([
            'login_as' => 'Rôle non reconnu.',
        ])->withInput();
    }

    // Redirection selon le rôle
    if ($request->login_as === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($request->login_as === 'moderator') {
        return redirect()->route('moderator.dashboard');
    }

    return redirect()->route('user.dashboard');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}