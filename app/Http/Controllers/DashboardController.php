<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Movimiento;
use App\Models\Semana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index()
{
    // Datos del usuario autenticado
    $user = Auth::user();
    $user_name = $user ? $user->name : 'Usuario Anónimo';
    $user_role = $user ? ($user->role ?? 'Sin rol') : 'Sin rol';

    // Estadísticas clave
    $total_articulos = Articulo::count();

    // Calcular stock total
    $stock_total = Articulo::sum('cantidad_inicial') +
        Movimiento::where('tipo', 'entrada')->sum('cantidad') -
        Movimiento::where('tipo', 'salida')->sum('cantidad');

    // Movimientos recientes de la última semana
    $fecha_inicio_semana = Carbon::now()->subDays(7)->startOfDay();
    $entradas_recientes = Movimiento::where('tipo', 'entrada')
        ->where('fecha', '>=', $fecha_inicio_semana)
        ->count();

    $salidas_recientes = Movimiento::where('tipo', 'salida')
        ->where('fecha', '>=', $fecha_inicio_semana)
        ->count();

    // Movimientos recientes (últimos 5)
    $movimientos_recientes = Movimiento::select('movimientos.id', 'movimientos.articulo_id', 'movimientos.cantidad', 'movimientos.tipo', 'movimientos.fecha', 'movimientos.valor_del_movimiento')
        ->with(['articulo' => function ($query) {
            $query->select('id', 'nombre', 'unidad_medida', 'precio_por_unidad', 'imagen'); // Added 'imagen'
        }])
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($movimiento) {
            $movimiento->valor_calculado = $movimiento->articulo ? ($movimiento->cantidad * $movimiento->articulo->precio_por_unidad) : 0;
            return $movimiento;
        });

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