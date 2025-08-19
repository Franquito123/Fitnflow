<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequirementController extends Controller
{
public function index()
{
    $requirements = Requirement::with('service')->latest('updated_at')->paginate(10);
    
    // Obtener la fecha de última actualización
    $lastUpdated = Requirement::latest('updated_at')->value('updated_at');
    $lastUpdated = $lastUpdated ? $lastUpdated->format('d/m/Y') : null;
    
    return view('admin.requirements.index', [
        'requirements' => $requirements,
        'lastUpdated' => $lastUpdated
    ]);
}
    public function create()
    {
        $services = Service::all();
        return view('admin.requirements.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:50|unique:requirements,name'
        ]);

        try {
            Requirement::create($validated);
            
            return redirect()->route('admin.requirements.index')
                   ->with('success', 'Requisito creado exitosamente');
                   
        } catch (\Exception $e) {
            Log::error('Error creating requirement: '.$e->getMessage());
            return back()->withInput()
                   ->with('error', 'Error al crear el requisito');
        }
    }

    public function edit(Requirement $requirement)
    {
        $services = Service::all();
        return view('admin.requirements.edit', compact('requirement', 'services'));
    }

    public function update(Request $request, Requirement $requirement)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:50|unique:requirements,name,'.$requirement->id
        ]);

        try {
            $requirement->update($validated);
            
            return redirect()->route('admin.requirements.index')
                   ->with('success', 'Requisito actualizado correctamente');
                   
        } catch (\Exception $e) {
            Log::error('Error updating requirement: '.$e->getMessage());
            return back()->withInput()
                   ->with('error', 'Error al actualizar el requisito');
        }
    }

    public function destroy(Requirement $requirement)
    {
        try {
            $requirement->delete();
            return redirect()->route('admin.requirements.index')
                   ->with('success', 'Requisito eliminado');
        } catch (\Exception $e) {
            Log::error('Error deleting requirement: '.$e->getMessage());
            return back()->with('error', 'Error al eliminar el requisito');
        }
    }
}