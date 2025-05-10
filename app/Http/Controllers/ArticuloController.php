<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Movimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{

/**
 * Muestra la lista de artículos con entradas, salidas y valor total de movimientos por mes.
 *
 * @param Request $request
 * @return \Illuminate\View\View
 */
public function index(Request $request)
{
    // Obtener la fecha seleccionada o la actual si no se proporciona
    $fechaSeleccionada = $request->input('fecha', Carbon::today()->format('Y-m-d'));
    $fecha = Carbon::parse($fechaSeleccionada);

    // Obtener el inicio y fin de la semana seleccionada
    $inicioSemana = $fecha->startOfWeek()->format('Y-m-d');
    $finSemana = $fecha->endOfWeek()->format('Y-m-d');

    // Obtener todos los artículos y calcular métricas
    $articulos = Articulo::all()->map(function ($articulo) use ($inicioSemana, $finSemana) {
        // Calcular la cantidad inicial hasta la semana anterior
        $ultimaSemana = Carbon::parse($inicioSemana)->subWeek()->endOfWeek()->format('Y-m-d');
        $cantidadInicial = Movimiento::where('articulo_id', $articulo->id)
            ->where('fecha', '<=', $ultimaSemana)
            ->sum(DB::raw("CASE WHEN tipo = 'entrada' THEN cantidad ELSE -cantidad END"));

        // Si no hay registros anteriores, usar la cantidad inicial del artículo
        $cantidadInicial = $cantidadInicial ?? $articulo->cantidad_inicial;

        // Calcular entradas y salidas de la semana actual
        $entradas = Movimiento::where('articulo_id', $articulo->id)
            ->where('tipo', 'entrada')
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->sum('cantidad');

        $salidas = Movimiento::where('articulo_id', $articulo->id)
            ->where('tipo', 'salida')
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->sum('cantidad');

        // Calcular el valor total de las salidas (vendido) en la semana
        $valorVentas = Movimiento::where('articulo_id', $articulo->id)
            ->where('tipo', 'salida')
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->sum('valor_del_movimiento');

        // Calcular el valor total de las entradas (stock agregado) en la semana
        $valorStockEntradas = $entradas * $articulo->precio_por_unidad;

        // Calcular cantidad actual
        $cantidadActual = $cantidadInicial + $entradas - $salidas;

        // Calcular el valor del stock (cantidad_actual * precio_por_unidad)
        $valorStock = $cantidadActual * $articulo->precio_por_unidad;

        // Actualizar valores del artículo
        $articulo->cantidad_inicial = $cantidadInicial;
        $articulo->entradas_semana = $entradas;
        $articulo->salidas_semana = $salidas;
        $articulo->cantidad_actual = $cantidadActual;
        $articulo->fecha_actualizacion = now()->format('d-m-Y');
        $articulo->valor_ventas_semana = $valorVentas;
        $articulo->valor_stock_entradas_semana = $valorStockEntradas;
        $articulo->valor_stock = $valorStock;

        return $articulo;
    });

    return view('articulos.index', compact('articulos', 'fechaSeleccionada'));
}
    public function create()
    {
        return view('articulos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'unidad_medida' => 'required|in:ml,kg,l,g',
            'precio_por_unidad' => 'required|numeric|min:0.01',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Si se subió una imagen, guardarla en el almacenamiento
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('articulos', 'public');
        }
     
        // La cantidad_inicial se mantiene como 0 por defecto en la base de datos
        Articulo::create($data);

        return redirect()->route('articulos.index')->with('success', 'Artículo creado');
    }

    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', compact('articulo'));
    }

   public function update(Request $request, Articulo $articulo)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'unidad_medida' => 'required|in:ml,kg,l,g',
        'precio_por_unidad' => 'required|numeric|min:0',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Si se subió una nueva imagen, eliminar la antigua y guardar la nueva
    if ($request->hasFile('imagen')) {
        if ($articulo->imagen) {
            Storage::disk('public')->delete($articulo->imagen);
        }
        $data['imagen'] = $request->file('imagen')->store('articulos', 'public');
    } else {
        $data['imagen'] = $articulo->imagen;
    }

    // No actualizamos cantidad_inicial, se mantiene el valor existente
    $articulo->update($data);

    return redirect()->route('articulos.index')->with('success', 'Artículo actualizado');
}

    public function destroy(Articulo $articulo)
    {
        if ($articulo->imagen) {
            Storage::disk('public')->delete($articulo->imagen);
        }

        $articulo->delete();
        return redirect()->route('articulos.index')->with('success', 'Artículo eliminado');
    }
}