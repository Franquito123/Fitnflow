<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Totales por estado
        $paymentStatuses = [
            'total' => Payment::count(),
            'approved' => Payment::where('status_id', 5)->count(),
            'pending' => Payment::where('status_id', 4)->count(),
            'rejected' => Payment::where('status_id', 6)->count(),
            'expired' => Payment::where('status_id', 7)->count()
        ];
        
        // Ingresos últimos 30 días
        $revenueLast30Days = Payment::where('status_id', 5)
            ->where('date', '>=', now()->subDays(30))
            ->sum('price');
        
        // Datos para gráfico de ingresos mensuales (últimos 12 meses)
        $monthlyRevenueData = $this->getMonthlyRevenueData(12);
        
        return view('admin.dashboard', compact(
            'paymentStatuses',
            'revenueLast30Days',
            'monthlyRevenueData'
        ));
    }
    
    public function getDashboardData($months = 12)
    {
        $data = $this->getMonthlyRevenueData($months);
        
        return response()->json([
            'labels' => $data['labels'],
            'data' => $data['data']
        ]);
    }
    
    protected function getMonthlyRevenueData($months = 12)
    {
        $revenueData = [];
        $monthNames = [];
        $now = Carbon::now();
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthName = $date->translatedFormat('M Y');
            
            $revenue = Payment::where('status_id', 5)
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('price');
            
            $revenueData[] = $revenue;
            $monthNames[] = $monthName;
        }
        
        return [
            'data' => $revenueData,
            'labels' => $monthNames,
            'max' => max($revenueData) ?: 1
        ];
    }
}