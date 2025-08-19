<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\CenterInformation;
use App\Models\CarouselSlide;
use App\Models\CarouselSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $services = Service::all(); // Obtener todos los servicios
        $centerInfo = CenterInformation::first(); // Obtener info del centro
        // 🔥 Asegúrate de obtener solo los slides activos
        $slides = CarouselSlide::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $settings = CarouselSetting::first(); // Configuración del carrusel

        return view('user.dashboard', compact('services', 'centerInfo', 'slides', 'settings'));
    }
}