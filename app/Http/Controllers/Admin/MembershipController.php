<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Status;
use Dompdf\Css\Style;
use Illuminate\Http\Request;
use Sabberworm\CSS\Value\Size;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::with('latestPayment')->get();
        return view('admin.memberships.index', compact('memberships'));
    }

    public function create()
    {
        // Filtrar solo los estados de tipo 1 (para membresías)
        $statuses = Status::where('type', 1)->get();
        return view('admin.memberships.create', compact('statuses'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:100', // Validación añadida (max 100 caracteres)
        'duration' => 'required|integer|min:1',
        'status_id' => 'required|exists:statuses,id',
        'price' => 'required|numeric|min:0',
    ], [
        'description.max' => 'La descripción no puede exceder los 100 caracteres.',
    ]);

    Membership::create([
        'name' => $request->name,
        'description' => $request->description,
        'duration' => $request->duration,
        'status_id' => $request->status_id,
        'price' => $request->price,
    ]);

    return redirect()->route('admin.memberships.index')->with('success', 'Membresía creada correctamente.');
}


    public function edit(Membership $membership)
    {
        $statuses = Status::where('type', 1)->get();
        return view('admin.memberships.edit', compact('membership', 'statuses'));
    }

public function update(Request $request, Membership $membership)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:100',
        'duration' => 'required|integer|min:1',
        'status_id' => 'required|exists:statuses,id',
        'price' => 'required|numeric|min:0',
    ], [
        'description.max' => 'La descripción no puede exceder los 100 caracteres.',
    ]);

    $membership->update($validated);

    return redirect()->route('admin.memberships.index')->with('success', 'Membresía actualizada correctamente.');
}
public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('admin.memberships.index')->with('success', 'Membresía eliminada correctamente.');
    }
}