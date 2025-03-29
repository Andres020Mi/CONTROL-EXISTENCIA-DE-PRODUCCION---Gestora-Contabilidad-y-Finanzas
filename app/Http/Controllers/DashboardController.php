<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Movimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos del usuario (asumiendo autenticación)
        $user = Auth::user();
        $user_name = $user ? $user->name : 'Usuario Anónimo';
        $user_role = $user && method_exists($user, 'getRoleNames') ? $user->role->first() : null;

        // Estadísticas clave
        $total_articulos = Articulo::count();

        // Calcular el stock total: cantidad_inicial + entradas - salidas
        $stock_total = Articulo::all()->sum(function ($articulo) {
            $entradas = Movimiento::where('articulo_id', $articulo->id)
                ->where('tipo', 'entrada')
                ->sum('cantidad');
            $salidas = Movimiento::where('articulo_id', $articulo->id)
                ->where('tipo', 'salida')
                ->sum('cantidad');
            return $articulo->cantidad_inicial + $entradas - $salidas;
        });

        $entradas_recientes = Movimiento::where('tipo', 'entrada')
            ->where('fecha', '>=', Carbon::now()->subDays(7))
            ->count();
        $salidas_recientes = Movimiento::where('tipo', 'salida')
            ->where('fecha', '>=', Carbon::now()->subDays(7))
            ->count();

        // Movimientos recientes (últimos 5)
        $movimientos_recientes = Movimiento::with('articulo')
            ->latest()
            ->take(5)
            ->get();

        // Preparar datos para la vista
        $dashboardData = [
            'user_name' => $user_name,
            'user_role' => $user_role,
            'total_articulos' => $total_articulos,
            'stock_total' => $stock_total,
            'entradas_recientes' => $entradas_recientes,
            'salidas_recientes' => $salidas_recientes,
            'movimientos_recientes' => $movimientos_recientes,
        ];

        return view('dashboard', compact('dashboardData'));
    }
}