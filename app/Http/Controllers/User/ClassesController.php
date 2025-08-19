<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Registration;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassesController extends Controller
{
    public function index()
{
    $disponibleStatusId = Status::where('type', 3)->where('name', 'Disponible')->value('id');
    $cupoLlenoStatusId = Status::where('type', 3)->where('name', 'Cupo lleno')->value('id');
    $canceladaStatusId = Status::where('type', 3)->where('name', 'Cancelada')->value('id'); 

    $classes = $disponibleStatusId
        ? Classes::withCount('registrations')
            ->with(['service.requirements', 'instructor', 'registrations'])
            ->where('status_id', $disponibleStatusId)
            ->where('date', '>=', now()->startOfDay())
            ->orderBy('date')
            ->orderBy('time')
            ->get()
        : collect();

    $userId = auth()->id();

    $upcomingRegistrations = Registration::with('class.service', 'class.instructor', 'class.status')
    ->where('user_id', $userId)
    ->whereHas('class', function ($query) use ($canceladaStatusId) {
        $query->where('date', '>=', now()->startOfDay())
              ->where('status_id', '!=', $canceladaStatusId);
    })
    ->get();


    // Mostrar solo clases canceladas recientemente que sigan en estado Rechazada
    $comments = Classes::with('service')
        ->where('status_id', $canceladaStatusId)
        ->whereNotNull('comment')
        ->where('comment', '!=', '')
        ->orderBy('date', 'desc')
        ->take(5)
        ->get();

    // Mostrar solo clases con estado actual "Cupo lleno"
    $clasesLlenas = Classes::with('service')
        ->where('status_id', $cupoLlenoStatusId)
        ->orderBy('date', 'desc')
        ->take(5)
        ->get();

    return view('user.classes.index', compact(
        'classes',
        'upcomingRegistrations',
        'comments',
        'clasesLlenas'
    ));
}


    public function reserve($classId)
    {
        $user = auth()->user();
        $class = Classes::findOrFail($classId);

        if ($class->registrations()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Ya estás registrado en esta clase.');
        }

        if ($class->registrations()->count() >= $class->max_capacity) {
            return back()->with('error', 'No hay cupos disponibles.');
        }

        $conflict = $user->registrations()
            ->whereHas('class', function ($query) use ($class) {
                $query->where('date', $class->date)->where('time', $class->time);
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Ya tienes una clase en ese horario.');
        }

        // Crear la inscripción
        Registration::create([
            'user_id' => $user->id,
            'class_id' => $class->id
        ]);

        // Verificar si se alcanzó el cupo y actualizar estado a "Cupo lleno"
        if ($class->registrations()->count() >= $class->max_capacity) {
            $cupoLlenoId = Status::where('type', 3)->where('name', 'Cupo lleno')->value('id');
            $class->status_id = $cupoLlenoId;
            $class->save();
        }

        return back()->with('success', 'Clase reservada con éxito.');
    }

    public function cancelReservation(Request $request, $classId)
    {
        $user = auth()->user();

        $registration = Registration::where('user_id', $user->id)
            ->where('class_id', $classId)
            ->first();

        if (!$registration) {
            return back()->with('error', 'No estás registrado en esta clase.');
        }

        $class = $registration->class;
        $date = Carbon::parse($class->date)->format('Y-m-d');
        $time = $class->time;
        $classDateTime = Carbon::parse("$date $time");

        if (now()->greaterThan($classDateTime->copy()->subHours(2))) {
            return back()->with('error', 'No puedes cancelar esta clase con menos de 2 horas de anticipación.');
        }

        $registration->delete();

        // Si el estado era "Cupo lleno" y ahora hay espacio, cambiar a "Disponible"
        $cupoLlenoId = Status::where('type', 3)->where('name', 'Cupo lleno')->value('id');
        $disponibleId = Status::where('type', 3)->where('name', 'Disponible')->value('id');

        if ($class->status_id == $cupoLlenoId && $class->registrations()->count() < $class->max_capacity) {
            $class->status_id = $disponibleId;
            $class->save();
        }

        return back()->with('success', 'Inscripción cancelada exitosamente.');
    }
    public function history()
{
    $userId = auth()->id();

    $reservas = Registration::with(['class.service', 'class.instructor', 'class.status'])
                ->where('user_id', $userId)
                ->orderByDesc('created_at')
                ->get();

    return view('user.classes.history', compact('reservas'));
}

}

