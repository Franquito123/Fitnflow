<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Service;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassesController extends Controller
{
    // Mostrar todas las clases
    public function index()
    {
        $classes = Classes::with(['service', 'instructor', 'status'])
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(10);

        return view('admin.classes.index', compact('classes'));
    }

    // Mostrar formulario para crear una clase
    public function create()
{
    $services = Service::all();

    // Solo instructores con status "Activo" de tipo 1
    $instructors = User::whereHas('role', function ($query) {
        $query->where('slug', 'instructor');
    })
    ->whereHas('status', function ($query) {
        $query->where('name', 'Activo')->where('type', 1); // Estado activo para usuarios
    })
    ->get();

    $statuses = Status::where('type', 3)->get(); // Estados para clases

    return view('admin.classes.create', compact('services', 'instructors', 'statuses'));
}



    // Guardar nueva clase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'     => 'required|exists:services,id',
            'instructor_id'  => 'required|exists:users,id',
            'status_id'      => 'required|exists:statuses,id',
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required|date_format:H:i',
            'description'    => 'required|string|max:500',
            'max_capacity'   => 'required|integer|min:1|max:30',
            'room'           => 'required|string|max:50',
        ]);

        Classes::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Clase creada exitosamente');
    }

    

    // Mostrar formulario para editar una clase
    public function edit(Classes $class)
{
    $services = Service::all();
    $instructors = User::whereHas('role', function ($query) {
        $query->where('slug', 'instructor');
    })
    ->whereHas('status', function ($query) {
        $query->where('name', 'Activo')->where('type', 1);
    })
    ->get();

    // Add this line to get the statuses for classes (type 3)
    $statuses = Status::where('type', 3)->get();

    return view('admin.classes.edit', compact('class', 'services', 'instructors', 'statuses'));
}

    // Actualizar clase (incluye actualización desde inscripciones)
   public function update(Request $request, Classes $class)
{
    if ($request->has('status_id') && !$request->has('service_id')) {
        // Solo actualización de estado y comentario desde inscripciones
        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'comment'   => 'nullable|string|max:500',
        ]);

        $class->update($validated);

        // Obtener ID del estado "Cancelada"
        $cancelledStatusId = Status::where('type', 3)->where('name', 'Cancelada')->value('id');

        // Si el estado NO es "Cancelada", resetear notification a 0
        if ($validated['status_id'] != $cancelledStatusId) {
            $class->notification = 0;
            $class->save();
        }

        return $request->input('from') === 'registrations'
            ? redirect()->route('admin.classes.registrations', $class->id)
                         ->with('success', 'Estado actualizado correctamente.')
            : redirect()->route('admin.classes.index')
                         ->with('success', 'Clase actualizada correctamente.');
    } else {
        // Actualización completa desde formulario de edición
        $validated = $request->validate([
            'service_id'    => 'required|exists:services,id',
            'instructor_id' => 'required|exists:users,id',
            'status_id'     => 'required|exists:statuses,id',
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i',
            'description'   => 'required|string|max:500',
            'max_capacity'  => 'required|integer|min:1|max:30',
            'room'          => 'required|string|max:50',
            'comment'       => 'nullable|string|max:500',
        ]);

        $class->update($validated);

        // Obtener ID del estado "Cancelada"
        $cancelledStatusId = Status::where('type', 3)->where('name', 'Cancelada')->value('id');

        // Si el estado NO es "Cancelada", resetear notification a 0
        if ($validated['status_id'] != $cancelledStatusId) {
            $class->notification = 0;
            $class->save();
        }

        return redirect()->route('admin.classes.index')
            ->with('success', 'Clase actualizada correctamente.');
    }
}




    // Eliminar clase
    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Clase eliminada exitosamente');
    }

    // Mostrar clases disponibles para usuarios
    public function availableClasses()
    {
        $services = Service::all();
        $classes = Classes::whereHas('status', function ($query) {
                $query->where('name', 'Activo')->where('type', 1);
            })
            ->where('date', '>=', Carbon::today())
            ->with(['service', 'instructor'])
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('classes.available', compact('classes', 'services'));
    }
    // NUEVO: Mostrar inscripciones para una clase
        public function registrations(Classes $class)
        {
    // Cargar relaciones necesarias
    $class->load('service', 'instructor', 'status');

    // Obtener inscripciones (asumiendo que tienes relación "registrations" en Classes)
    $inscritos = $class->registrations()->with('user')->get();

    // Calcular cupos restantes
    $faltantes = $class->max_capacity - $inscritos->count();

    // Obtener estados tipo 3 para cambiar estado de clase desde la vista de inscripciones
    $classStatuses = Status::where('type', 3)->get();

            return view('admin.classes.registrations', compact('class', 'inscritos', 'faltantes', 'classStatuses'));
        }

}
