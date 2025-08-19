<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordChangedNotification;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function index(Request $request) 
{
    $query = User::with(['role', 'status']);

    // Rol seleccionado en el filtro (por defecto 2 = usuario)
    $roleFilter = $request->input('roleFilter', '2');

    // Filtro de estado (activo/inactivo)
    $statusFilter = $request->input('statusFilter');

    // Filtra por rol
    $query->where('rol_id', $roleFilter);

    // Filtra por estado si está seleccionado
    if ($statusFilter) {
        $query->where('status_id', $statusFilter);
    }

    // Resto de tus filtros existentes...
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('names', 'like', '%'.$request->search.'%')
              ->orWhere('last_name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%');
        });
    }

    if ($roleFilter == '3') {
        if ($request->filled('specialtyFilter')) {
            $query->where('specialty', $request->specialtyFilter);
        }
        
        if ($request->filled('certificationFilter')) {
            $query->where('certification', $request->certificationFilter);
        }
    }

    $users = $query->paginate(10);

    $specialties = $roleFilter == '3' ? User::where('rol_id', 3)->whereNotNull('specialty')->distinct()->pluck('specialty') : [];
    $certifications = $roleFilter == '3' ? User::where('rol_id', 3)->whereNotNull('certification')->distinct()->pluck('certification') : [];
    $statuses = Status::all(); // Para el filtro de estado

    return view('admin.users.index', compact('users', 'specialties', 'certifications', 'roleFilter', 'statuses'));
}

    public function create(Request $request)
    {
        $roles = Role::all();
        $statuses = Status::all();
        $redirectFilter = $request->input('redirect_filter', '2'); // Por defecto usuario

        return view('admin.users.create', compact('roles', 'statuses', 'redirectFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Masculino,Femenino,Otro',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|integer|exists:roles,id',
            'status_id' => 'required|integer|exists:statuses,id',
            'specialty' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
        ]);

        User::create([
            'names' => $request->names,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'status_id' => $request->status_id,
            'specialty' => $request->specialty,
            'certification' => $request->certification,
        ]);

        return redirect()->route('admin.users.index', [
            'roleFilter' => $request->redirect_filter ?? '2'
        ])->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        $user->load(['role', 'status']);
        $edad = Carbon::parse($user->birth_date)->age;

        return view('admin.users.show', compact('user', 'edad'));
    }

    public function edit(Request $request, User $user)
    {
        $roles = Role::all();
        $statuses = Status::all();
        $user->load(['role', 'status']);
        $redirectFilter = $request->input('redirect_filter', '2');

        return view('admin.users.edit', compact('user', 'roles', 'statuses', 'redirectFilter'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'names' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'gender' => 'required|string|in:Masculino,Femenino,Otro',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'rol_id' => 'required|integer|exists:roles,id',
        'status_id' => 'required|integer|exists:statuses,id',
        'specialty' => 'nullable|string|max:255',
        'certification' => 'nullable|string|max:255',
    ]);

    $data = $request->only([
        'names', 'last_name', 'birth_date', 'gender', 'email',
        'rol_id', 'status_id', 'specialty', 'certification'
    ]);

    if ($request->filled('password')) {
        $plainPassword = $request->password; // Guardar para notificación
        $data['password'] = Hash::make($plainPassword);
        $user->update($data);

        // ✅ Enviar notificación después de actualizar
        $user->notify(new PasswordChangedNotification($plainPassword));
    } else {
        $user->update($data);
    }

    return redirect()->route('admin.users.index', [
        'roleFilter' => $request->redirect_filter ?? '2'
    ])->with('success', 'Usuario actualizado exitosamente.');
}

    public function destroy(User $user)
    {
        // Verificar si el usuario tiene pagos relacionados
        if ($user->payments()->exists()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No se puede eliminar el usuario porque tiene pagos registrados.');
        }

        // Si no tiene pagos, se elimina con seguridad
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}