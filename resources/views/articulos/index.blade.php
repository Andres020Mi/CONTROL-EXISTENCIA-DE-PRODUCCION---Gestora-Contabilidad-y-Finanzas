@extends('layouts.master')

@section('title')
    Gestión de Existencias
@endsection

@section('links_css_head')
    <!-- Estilos personalizados -->
    <style>
        .content-wrapper {
            padding: 20px;
        }

        .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
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
        }

        .card-body {
            padding: 1.25rem;
        }

        .btn-success {
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-success:hover {
            background-color: #166534;
            border-color: #166534;
        }

        .btn-warning {
            background-color: #ca8a04;
            border-color: #ca8a04;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            min-width: 120px;
        }

        .btn-warning:hover {
            background-color: #a16207;
            border-color: #a16207;
        }

        .btn-danger {
            background-color: #b91c1c;
            border-color: #b91c1c;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            min-width: 120px;
        }

        .btn-danger:hover {
            background-color: #991b1b;
            border-color: #991b1b;
        }

        .week-filter {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 0.25rem;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .week-filter label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0;
        }

        .week-filter input[type="week"] {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .week-filter input[type="week"]:focus {
            border-color: #15803d;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
        }

        .week-filter button {
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            font-size: 0.875rem;
        }

        .week-filter button:hover {
            background-color: #166534;
            border-color: #166534;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table thead th {
            background-color: #15803d;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
            background-color: #fff;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .actions {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            justify-content: center;
        }

        .thumbnail {
            max-width: 50px;
            max-height: 50px;
            border-radius: 0.25rem;
        }

        @media (max-width: 768px) {
            .actions {
                flex-direction: row;
                justify-content: flex-start;
                gap: 0.25rem;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .week-filter {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .btn-success, .btn-warning, .btn-danger {
                min-width: 100px;
                padding: 0.3rem 0.5rem;
            }

            .thumbnail {
                max-width: 40px;
                max-height: 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('DataTables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('DataTables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Agregar SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestión de Existencias</h3>
            </div>
            <div class="card-body">
                <!-- Formulario para seleccionar la semana -->
                <form method="GET" action="{{ route('articulos.index') }}" class="week-filter">
                    <label for="fecha">Filtrar por Semana:</label>
                    <input type="week" id="fecha" name="fecha" value="{{ $fechaSeleccionada }}" required>
                    <button type="submit">Aplicar</button>
                </form>

                <div class="mb-3">
                    <a href="{{ route('articulos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Nuevo Artículo
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="miTabla" class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Inicial</th>
                                <th>Entradas</th>
                                <th>Salidas</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articulos as $articulo)
                                <tr>
                                    <td>{{ $articulo->id }}</td>
                                    <td>
                                        @if ($articulo->imagen)
                                            <img src="{{ Storage::url($articulo->imagen) }}" alt="{{ $articulo->nombre }}" class="thumbnail">
                                        @else
                                            Sin imagen
                                        @endif
                                    </td>
                                    <td>{{ $articulo->nombre }}</td>
                                    <td>{{ $articulo->unidad_medida }}</td>
                                    <td>{{ $articulo->cantidad_inicial }}</td>
                                    <td>{{ $articulo->entradas_semana }}</td>
                                    <td>{{ $articulo->salidas_semana }}</td>
                                    <td>{{ $articulo->cantidad_actual }}</td>
                                    <td>{{ $articulo->fecha_actualizacion }}</td>
                                    <td class="actions">
                                        <a href="{{ route('articulos.edit', $articulo->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-btn">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 20px;">
                                        <i class="fas fa-exclamation-circle"></i> No hay artículos disponibles
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('DataTables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('DataTables/jszip.min.js') }}"></script>
    <script src="{{ asset('DataTables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('DataTables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.print.min.js') }}"></script>

    <!-- Inicialización de DataTables -->
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ entradas por página",
                    zeroRecords: "No se encontraron resultados",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "Sin registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: 9, orderable: false } // Desactiva ordenación en "Acciones"
                ]
            });

            // Manejo de la eliminación con SweetAlert2
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar esta existencia? Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection