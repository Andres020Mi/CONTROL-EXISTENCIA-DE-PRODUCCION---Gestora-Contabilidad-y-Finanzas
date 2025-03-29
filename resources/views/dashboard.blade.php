@extends('layouts.master')

@section('title')
    Dashboard - Gestión de Artículos SENA
@endsection

@section('links_css_head')
    <style>
        .content-wrapper {
            padding: 20px;
        }

        .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: #15803d;
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 1.25rem;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 2rem;
            color: #15803d;
            font-weight: bold;
        }

        .welcome-text {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 0.25rem;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.3s;
        }

        .stat-card:hover {
            background-color: #e9f7e9;
        }

        .stat-number {
            font-size: 1.75rem;
            color: #15803d;
            font-weight: bold;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        .movements-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .movements-table th, .movements-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .movements-table th {
            background-color: #15803d;
            color: #fff;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .movements-table tr:hover {
            background-color: #f8f9fa;
        }

        .thumbnail {
            max-width: 50px;
            max-height: 50px;
            border-radius: 0.25rem;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 10px;
            }
            .welcome-title {
                font-size: 1.5rem;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .movements-table {
                font-size: 0.9rem;
            }
            .thumbnail {
                max-width: 40px;
                max-height: 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Sección de bienvenida -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bienvenido, {{ $dashboardData['user_name'] }} {{ $dashboardData['user_role'] ? '(' . $dashboardData['user_role'] . ')' : '' }}</h3>
            </div>
            <div class="card-body">
                <div class="welcome-section">
                    <h1 class="welcome-title">Gestión de Artículos - SENA</h1>
                    <p class="welcome-text">
                        Este sistema, desarrollado para el SENA, permite una gestión eficiente de los artículos utilizados en las unidades de producción. Controla inventarios, registra movimientos y optimiza el uso de recursos para apoyar la formación técnica y las prácticas sostenibles.
                    </p>
                </div>
            </div>
        </div>

        <!-- Estadísticas clave -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resumen de Artículos</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $dashboardData['total_articulos'] }}</div>
                        <div class="stat-label">Artículos Registrados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $dashboardData['stock_total'] }}</div>
                        <div class="stat-label">Stock Total</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $dashboardData['entradas_recientes'] }}</div>
                        <div class="stat-label">Entradas Recientes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $dashboardData['salidas_recientes'] }}</div>
                        <div class="stat-label">Salidas Recientes</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movimientos recientes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Movimientos Recientes</h3>
            </div>
            <div class="card-body">
                <table class="movements-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Artículo</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dashboardData['movimientos_recientes'] as $movimiento)
                            <tr>
                                <td>
                                    @if ($movimiento->articulo && $movimiento->articulo->imagen)
                                        <img src="{{ Storage::url($movimiento->articulo->imagen) }}" alt="{{ $movimiento->articulo->nombre }}" class="thumbnail">
                                    @else
                                        Sin imagen
                                    @endif
                                </td>
                                <td>{{ $movimiento->articulo->nombre ?? 'N/A' }}</td>
                                <td>{{ ucfirst($movimiento->tipo) }}</td>
                                <td>{{ $movimiento->cantidad }}</td>
                                <td>{{ $movimiento->fecha->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay movimientos recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
@endsection