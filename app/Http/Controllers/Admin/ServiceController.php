<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:15|regex:/^[A-Za-z\s\-]+$/|unique:services,name',
        'description' => 'required|string|max:400|regex:/^[A-Za-z\s\-]+$/',
        'image_url' => 'required|image|mimes:jpeg,jpg,png|max:2048',
    ], [
        'name.required' => 'El nombre del servicio es obligatorio.',
        'name.string' => 'El nombre del servicio debe ser una cadena de texto.',
        'name.max' => 'El nombre no puede exceder 15 caracteres.',
        'name.unique' => 'Este nombre de servicio ya existe.',
        'name.regex' => 'El nombre solo debe contener letras, espacios y guiones.',

        'description.required' => 'La descripción es obligatoria.',
        'description.string' => 'La descripción debe ser texto.',
        'description.max' => 'La descripción no puede exceder 400 caracteres.',
        'description.regex' => 'La descripción solo debe contener letras, espacios y guiones.',

        'image_url.required' => 'La imagen es obligatoria.',
        'image_url.image' => 'El archivo debe ser una imagen.',
        'image_url.mimes' => 'El formato de la imagen debe ser JPEG, JPG o PNG.',
        'image_url.max' => 'La imagen no puede pesar más de 2 MB.',
    ]);

    $service = new Service();
    $service->name = $validatedData['name'];
    $service->description = $validatedData['description'];

    if ($request->hasFile('image_url')) {
        $path = $request->file('image_url')->store('services', 'public');
        $service->image_url = $path;
    }

    $service->save();

    return redirect()->route('admin.service.index')->with('success', 'Servicio creado correctamente.');
}


    public function show(Service $service)
    {
        return view('admin.service.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:100|regex:/^[A-Za-z\s\-]+$/|unique:services,name,' . $service->id,
        'description' => 'required|string|max:400|regex:/^[A-Za-z\s\-]+$/',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'name.required' => 'El nombre del servicio es obligatorio.',
        'name.string' => 'El nombre del servicio debe ser una cadena de texto.',
        'name.max' => 'El nombre no puede exceder 100 caracteres.',
        'name.unique' => 'Este nombre de servicio ya existe.',
        'name.regex' => 'El nombre solo debe contener letras, espacios y guiones.',

        'description.required' => 'La descripción es obligatoria.',
        'description.string' => 'La descripción debe ser texto.',
        'description.max' => 'La descripción no puede exceder 400 caracteres.',
        'description.regex' => 'La descripción solo debe contener letras, espacios y guiones.',

        'image_url.image' => 'El archivo debe ser una imagen.',
        'image_url.mimes' => 'El formato de la imagen debe ser JPEG, JPG o PNG.',
        'image_url.max' => 'La imagen no puede pesar más de 2 MB.',
    ]);

    $service->name = $validatedData['name'];
    $service->description = $validatedData['description'];

    if ($request->hasFile('image_url')) {
        if ($service->image_url && Storage::disk('public')->exists($service->image_url)) {
            Storage::disk('public')->delete($service->image_url);
        }

        $path = $request->file('image_url')->store('services', 'public');
        $service->image_url = $path;
    }

    $service->save();

    return redirect()->route('admin.service.index')->with('success', 'Servicio actualizado correctamente.');
}


    public function destroy(Service $service)
    {
        if ($service->image_url && Storage::disk('public')->exists($service->image_url)) {
            Storage::disk('public')->delete($service->image_url);
        }

        $service->delete();

        return redirect()->route('admin.service.index')
                         ->with('success', 'Servicio eliminado.');
    }
}