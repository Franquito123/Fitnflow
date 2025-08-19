<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // 1) Validación
    $data = $request->validate([
        'names'           => ['required', 'string', 'max:255'],
        'last_name'       => ['required', 'string', 'max:255'],
        'birth_date'      => ['required', 'date'],
        'gender'          => ['required', 'string', 'max:255'],
        'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'        => ['required', 'confirmed', Rules\Password::defaults()],
        'specialty'       => ['nullable', 'string', 'max:255'],
        'certification'   => ['nullable', 'string', 'max:255'],
    ]);

    // 2) Rol por defecto
    $defaultRole = Role::where('slug', Role::USUARIO)->firstOrFail();

    // 3) Crear usuario
    $user = User::create([
        'names'         => $data['names'],
        'last_name'     => $data['last_name'],
        'birth_date'    => $data['birth_date'],
        'gender'        => $data['gender'],
        'email'         => $data['email'],
        'password'      => Hash::make($data['password']),
        'rol_id'        => $defaultRole->id,
        'status_id'     => 1,
        'specialty'     => $data['specialty']     ?? null,
        'certification' => $data['certification'] ?? null,
    ]);

    // 4) Evento (sin login automático)
    event(new Registered($user));

    // 5) Redirección al login
    return redirect()->route('login')->with('success', 'Registro completado. Por favor, inicia sesión.');
}


}