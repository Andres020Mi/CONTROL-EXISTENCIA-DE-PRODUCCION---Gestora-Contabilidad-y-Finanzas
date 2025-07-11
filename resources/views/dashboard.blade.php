@extends('layouts.master')

@section('title')
    Dashboard - Gestión de Existencias SENA
@endsection

@section('links_css_head')
    <style>
        :root {
            --primary-color: #15803d;
            --text-color: #333;
            --background-color: #fff;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --border-radius: 0.25rem;
        }

        .content-wrapper {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Componente: Card */
        .card {
            background-color: var(--background-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Componente: Welcome Section */
        .welcome-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: bold;
            animation: fadeIn 1s ease-in;
        }

        .welcome-text {
            font-size: 1.2rem;
            color: var(--text-color);
            line-height: 1.6;
            animation: fadeIn 1.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Componente: Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background-color: var(--background-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: background-color 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            background-color: #e9f7e9;
            transform: scale(1.05);
        }

        .stat-number {
            font-size: 1.75rem;
            color: var(--primary-color);
            font-weight: bold;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        /* Componente: Table */
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
            background-color: var(--primary-color);
            color: #fff;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .movements-table tr {
            transition: background-color 0.3s;
        }

        .movements-table tr:hover {
            background-color: #f8f9fa;
        }

        .thumbnail {
            max-width: 50px;
            max-height: 50px;
            border-radius: var(--border-radius);
        }

        /* Responsive Design */
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
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Componente: Welcome Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bienvenido, {{ $dashboardData['user_name'] }} {{ $dashboardData['user_role'] ? '(' . $dashboardData['user_role'] . ')' : '' }}</h3>
            </div>
            <div class="card-body">
                <div class="welcome-section">
                    <h1 class="welcome-title">Gestión de Existencias - SENA</h1>
                    <p class="welcome-text">
                        Este sistema, desarrollado para el SENA, permite una gestión eficiente de los inventarios. Controla existencias y registra movimientos.
                    </p>
                </div>
            </div>
        </div>

        <!-- Componente: Estadísticas Clave -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resumen de Existencias</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($dashboardData['total_articulos'], 0, ',', '.') }}</div>
                        <div class="stat-label">Existencias Registrados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($dashboardData['stock_total'], 0, ',', '.') }}</div>
                        <div class="stat-label">Stock Total</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($dashboardData['entradas_recientes'], 0, ',', '.') }}</div>
                        <div class="stat-label">Entradas Recientes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($dashboardData['salidas_recientes'], 0, ',', '.') }}</div>
                        <div class="stat-label">Salidas Recientes</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Componente: Movimientos Recientes -->
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
                            <th>Unidad</th>
                            <th>Valor</th>
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
                                <td>{{ number_format($movimiento->cantidad, 0, ',', '.') }}</td>
                                <td>{{ $movimiento->articulo->unidad_medida ?? 'N/A' }}</td>
                                <td>$ {{ number_format($movimiento->valor_calculado, 0, ',', '.') }}</td>
                                <td>{{ $movimiento->fecha->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay movimientos recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts_end_body')
    <!-- No scripts needed since we removed the chart and alert interactions -->
@endsection