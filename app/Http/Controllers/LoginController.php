<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return $this->authenticatedRedirect();
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    protected function authenticatedRedirect()
    {
        $user = Auth::user();

        // Validar si tiene un rol asignado por 'rol_id'
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'Tu cuenta no tiene un rol asignado']);
        }

        // Redireccionar según el rol
        if ($user->hasRole(Role::ADMIN)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole(Role::INSTRUCTOR)) {
            return redirect()->intended(route('instructor.dashboard'));
        }

        if ($user->hasRole(Role::USUARIO)) {
            return redirect()->intended(route('user.dashboard'));
        }

        // Si el rol no es reconocido
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
