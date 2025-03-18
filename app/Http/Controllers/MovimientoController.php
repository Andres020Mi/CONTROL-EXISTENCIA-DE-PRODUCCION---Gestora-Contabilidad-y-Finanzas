<?php
namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Articulo;
use App\Models\Semana;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    // Guardar un nuevo movimiento
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

        $semana = Semana::where('inicio', $inicioSemana)->where('fin', $finSemana)->first();
        if (!$semana) {
            $semana = Semana::create([
                'inicio' => $inicioSemana,
                'fin' => $finSemana,
                'cantidad_total' => 0,
            ]);
        }

        Movimiento::create([
            'articulo_id' => $request->articulo_id,
            'cantidad' => $request->cantidad,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
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