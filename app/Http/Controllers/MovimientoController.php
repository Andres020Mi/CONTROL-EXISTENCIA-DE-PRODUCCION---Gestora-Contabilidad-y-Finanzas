<?php
namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Articulo;
use App\Models\Semana;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovimientoController extends Controller
{
    public function index()
    {
        $movimientos = Movimiento::with(['articulo', 'semana'])->latest()->get();
        return view('movimientos.index', compact('movimientos'));
    }

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

        // Convertir la fecha proporcionada a un objeto Carbon
        $fecha = Carbon::parse($request->fecha);
        $inicioSemana = $fecha->startOfWeek()->toDateString();
        $finSemana = $fecha->endOfWeek()->toDateString();

        // Buscar la semana correspondiente
        $semana = Semana::where('inicio', $inicioSemana)->where('fin', $finSemana)->first();

        // Si no existe la semana, la creamos con la cantidad total inicial de 0
        if (!$semana) {
            $semana = Semana::create([
                'inicio' => $inicioSemana,
                'fin' => $finSemana,
                'cantidad_total' => 0, // Se actualizará después con los movimientos
            ]);
        }

        // Crear el movimiento con la semana asignada
        Movimiento::create([
            'articulo_id' => $request->articulo_id,
            'cantidad' => $request->cantidad,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'semana_id' => $semana->id,
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }
}
