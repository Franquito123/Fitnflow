<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use App\Models\CarouselSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselSlideController extends Controller
{
    public function index()
    {
    $slides = CarouselSlide::orderBy('display_order')->paginate(10);
    $settings = CarouselSetting::first();
    return view('admin.carousel.index', compact('slides', 'settings'));
    }

    public function create()
{
    $nextOrder = CarouselSlide::max('display_order') + 1 ?? 1;
    return view('admin.carousel.create', compact('nextOrder'));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'description'   => 'nullable|string|max:255',
        'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'link_url'      => 'nullable|url',
        'display_order' => 'required|integer',
        'is_active'     => 'required|boolean',
    ]);

    // ✅ Verificar manualmente si ya existe ese número de orden
    $orderExists = CarouselSlide::where('display_order', $validated['display_order'])->exists();

    if ($orderExists) {
        return back()
            ->withErrors(['display_order' => 'Ya existe un slide con este orden. Elige otro número.'])
            ->withInput();
    }

    // ✅ Guardar imagen
    $path = $request->file('image')->store('slides', 'public');

    // ✅ Crear slide
    $slide = new CarouselSlide();
    $slide->description    = $validated['description'] ?? null;
    $slide->image_path     = $path;
    $slide->link_url       = $validated['link_url'] ?? null;
    $slide->display_order  = $validated['display_order'];
    $slide->is_active      = $validated['is_active'];

    $slide->save();

    return redirect()->route('admin.carousel.index')->with('success', 'Slide guardado correctamente.');
}





    public function edit(CarouselSlide $carousel)
    {
        return view('admin.carousel.edit', ['carousel' => $carousel]);
    }

    public function update(Request $request, CarouselSlide $carousel)
    {
        $validated = $request->validate([
            'description'    => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_url'       => 'nullable|url',
            'display_order'  => 'required|integer',
            'is_active'      => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($carousel->image_path && Storage::disk('public')->exists($carousel->image_path)) {
                Storage::disk('public')->delete($carousel->image_path);
            }

            $carousel->image_path = $request->file('image')->store('slides', 'public');
        }

        $carousel->update([
            'description'    => $validated['description'] ?? null,
            'link_url'       => $validated['link_url'] ?? null,
            'display_order'  => $validated['display_order'],
            'is_active'      => $validated['is_active'],
            'image_path'     => $carousel->image_path,
        ]);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide actualizado correctamente.');
    }

    public function destroy(CarouselSlide $carousel)
    {
        if ($carousel->image_path && Storage::disk('public')->exists($carousel->image_path)) {
            Storage::disk('public')->delete($carousel->image_path);
        }

        $carousel->delete();
        return redirect()->route('admin.carousel.index')->with('success', 'Slide eliminado correctamente.');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'style' => 'required|in:ring,flat,stacked',
            'radius' => 'required|integer|min:100|max:1000',
            'duration' => 'required|integer|min:5|max:60',
        ]);

        $settings = CarouselSetting::first() ?? new CarouselSetting();
        $settings->style = $validated['style'];
        $settings->radius = $validated['radius'];
        $settings->duration = $validated['duration'];
        $settings->brightness_animation = $request->has('brightness_animation');
        $settings->save();

        return redirect()->route('admin.carousel.index')->with('success', 'Configuración guardada correctamente.');
    }
}