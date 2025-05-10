<?php
namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Articulo;
use App\Models\Semana;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class MovimientoController extends Controller
{
    // Listar movimientos
    public function index()
    {
        $movimientos = Movimiento::with(['articulo', 'semana'])->latest()->get();
        return view('movimientos.index', compact('movimientos'));
    }

    // Mostrar formulario para crear un nuevo movimiento
    public function create()
    {
        $articulos = Articulo::all();
        return view('movimientos.create', compact('articulos'));
    }

public function store(Request $request)
{
    $request->validate([
        'articulo_id' => 'required|exists:articulos,id',
        'cantidad' => 'required|integer|min:1',
        'tipo' => 'required|in:entrada,salida',
        'fecha' => 'required|date',
        
    ]);

    $fecha = Carbon::parse($request->fecha);
    $inicioSemana = $fecha->startOfWeek()->toDateString();
    $finSemana = $fecha->endOfWeek()->toDateString();

    // Verificar stock para movimientos de salida
    if ($request->tipo === 'salida') {
        $articulo = Articulo::find($request->articulo_id);
        
        // Calcular la cantidad inicial hasta la semana anterior
        $ultimaSemana = Carbon::parse($inicioSemana)->subWeek()->endOfWeek()->toDateString();
        $cantidadInicial = Movimiento::where('articulo_id', $articulo->id)
            ->where('fecha', '<=', $ultimaSemana)
            ->sum(DB::raw("CASE WHEN tipo = 'entrada' THEN cantidad ELSE -cantidad END"));

        // Si no hay movimientos previos, usar cantidad inicial del artículo
        $cantidadInicial = $cantidadInicial ?: $articulo->cantidad_inicial;

        // Calcular entradas y salidas de la semana actual hasta la fecha del movimiento
        $entradas = Movimiento::where('articulo_id', $articulo->id)
            ->where('tipo', 'entrada')
            ->whereBetween('fecha', [$inicioSemana, $request->fecha])
            ->sum('cantidad');

        $salidas = Movimiento::where('articulo_id', $articulo->id)
            ->where('tipo', 'salida')
            ->whereBetween('fecha', [$inicioSemana, $request->fecha])
            ->sum('cantidad');

        // Calcular stock actual
        $stockActual = $cantidadInicial + $entradas - $salidas;

        // Verificar si hay suficiente stock
        if ($request->cantidad > $stockActual) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para registrar la salida.');
        }
    }

    // Crear o buscar semana
    $semana = Semana::where('inicio', $inicioSemana)->where('fin', $finSemana)->first();
    if (!$semana) {
        $semana = Semana::create([
            'inicio' => $inicioSemana,
            'fin' => $finSemana,
            'cantidad_total' => 0,
        ]);
    }

    // Obtener el precio por unidad del artículo
    $articulo = Articulo::find($request->articulo_id);
    $precioPorUnidad = $articulo->precio_por_unidad ?? 0; // Asegurarse de que no sea null
    $valorDelMovimiento = $request->cantidad * $precioPorUnidad;

    // Registrar el movimiento con el valor del movimiento
    Movimiento::create([
        'articulo_id' => $request->articulo_id,
        'cantidad' => $request->cantidad,
        'tipo' => $request->tipo,
        'fecha' => $request->fecha,
        'valor_del_movimiento' => $valorDelMovimiento, // Nuevo campo
        'semana_id' => $semana->id,
    ]);

    return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
}

    // Mostrar formulario para editar un movimiento
    public function edit(Movimiento $movimiento)
    {
        $articulos = Articulo::all();
        return view('movimientos.edit', compact('movimiento', 'articulos'));
    }

    // Actualizar un movimiento existente
    public function update(Request $request, Movimiento $movimiento)
    {
        $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required|integer|min:1',
            'tipo' => 'required|in:entrada,salida',
            'fecha' => 'required|date',
        ]);

        $fecha = Carbon::parse($request->fecha);
        $inicioSemana = $fecha->startOfWeek()->toDateString();
        $finSemana = $fecha->endOfWeek()->toDateString();

        $semana = Semana::where('inicio', $inicioSemana)->where('fin', $finSemana)->first();
        if (!$semana) {
            $semana = Semana::create([
                'inicio' => $inicioSemana,
                'fin' => $finSemana,
                'cantidad_total' => 0,
            ]);
        }

        $movimiento->update([
            'articulo_id' => $request->articulo_id,
            'cantidad' => $request->cantidad,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'semana_id' => $semana->id,
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento actualizado correctamente.');
    }

    // Eliminar un movimiento
    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();
        return redirect()->route('movimientos.index')->with('success', 'Movimiento eliminado correctamente.');
    }
}