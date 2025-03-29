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
    public function index(Request $request)
    {
        // Obtener la fecha seleccionada o la actual si no se proporciona
        $fechaSeleccionada = $request->input('fecha', Carbon::today()->format('Y-m-d'));
        $fecha = Carbon::parse($fechaSeleccionada);
    
        $inicioSemana = $fecha->startOfWeek()->format('Y-m-d');
        $finSemana = $fecha->endOfWeek()->format('Y-m-d');
    
        $articulos = Articulo::all()->map(function ($articulo) use ($inicioSemana, $finSemana) {
            // Obtener la última cantidad final registrada de la semana anterior
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
    
            // Actualizar valores del artículo
            $articulo->cantidad_inicial = $cantidadInicial;
            $articulo->entradas_semana = $entradas;
            $articulo->salidas_semana = $salidas;
            $articulo->cantidad_actual = $cantidadInicial + $entradas - $salidas;
            $articulo->fecha_actualizacion = now()->format('d-m-Y');
    
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