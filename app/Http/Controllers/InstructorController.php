<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Obtener registros de alumnos en clases impartidas por el instructor actual
        $registrations = Registration::with(['user', 'class.service']) // incluir relaciones necesarias
            ->whereHas('class', function ($query) use ($user) {
                $query->where('instructor_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();
        return view('instructor.dashboard', compact('registrations'));
    }
}
