<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        // // 🔹 Insertar 100 artículos
        // $articulos = [];
        // for ($i = 1; $i <= 100; $i++) {
        //     $articulos[] = [
        //         'nombre' => 'Artículo ' . $i,
        //         'unidad_medida' => ['ml', 'kg', 'l', 'g'][array_rand(['ml', 'kg', 'l', 'g'])],
        //         'cantidad_inicial' => rand(50, 500),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }
        // DB::table('articulos')->insert($articulos);

        // // 🔹 Insertar 52 semanas (1 año completo)
        // $semanas = [];
        // $inicio = Carbon::now()->startOfYear()->startOfWeek();
        // for ($i = 0; $i < 52; $i++) {
        //     $fin = $inicio->copy()->endOfWeek();
        //     $semanas[] = [
        //         'inicio' => $inicio->toDateString(),
        //         'fin' => $fin->toDateString(),
        //         'cantidad_total' => 0, // Se actualizará dinámicamente con movimientos
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        //     $inicio->addWeek();
        // }
        // DB::table('semanas')->insert($semanas);

        // // 🔹 Insertar 50,000 movimientos aleatorios
        // $movimientos = [];
        // $articulosDB = DB::table('articulos')->pluck('id')->toArray();
        // $semanasDB = DB::table('semanas')->pluck('id')->toArray();

        // for ($i = 0; $i < 5000; $i++) {
        //     $articulo_id = $articulosDB[array_rand($articulosDB)];
        //     $semana_id = $semanasDB[array_rand($semanasDB)];
        //     $tipo = ['entrada', 'salida'][rand(0, 1)];
        //     $cantidad = rand(1, 100);
        //     $fecha = Carbon::parse(DB::table('semanas')->where('id', $semana_id)->value('inicio'))
        //         ->addDays(rand(0, 6))
        //         ->toDateString();

        //     $movimientos[] = [
        //         'articulo_id' => $articulo_id,
        //         'cantidad' => $cantidad,
        //         'tipo' => $tipo,
        //         'fecha' => $fecha,
        //         'semana_id' => $semana_id,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];

        //     // Insertar en lotes de 5000 para mejorar rendimiento
        //     if ($i % 5000 === 0) {
        //         DB::table('movimientos')->insert($movimientos);
        //         $movimientos = [];
        //     }
        // }

        // // Insertar los movimientos restantes
        // if (!empty($movimientos)) {
        //     DB::table('movimientos')->insert($movimientos);
        // }
    }
}
