@extends('layouts.master')

@section('title')
    Lista de Movimientos
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
                <h3 class="card-title">Lista de Movimientos</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('movimientos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Registrar Movimiento
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="miTabla" class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>valor del movimiento</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Semana</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movimientos as $movimiento)
                                <tr>
                                    <td>{{ $movimiento->id }}</td>
                                    <td>
                                        @if ($movimiento->articulo && $movimiento->articulo->imagen)
                                            <img src="{{ Storage::url($movimiento->articulo->imagen) }}" alt="{{ $movimiento->articulo->nombre }}" class="thumbnail">
                                        @else
                                            Sin imagen
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->articulo->nombre ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td name="cops">{{ $movimiento->valor_del_movimiento }}</td>
                                    <td>{{ ucfirst($movimiento->tipo) }}</td>
                                    <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $movimiento->semana->inicio ?? 'N/A' }} - {{ $movimiento->semana->fin ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('movimientos.edit', $movimiento->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('movimientos.destroy', $movimiento->id) }}" method="POST" class="delete-form" style="display:inline;">
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
                                    <td colspan="9" style="text-align: center; padding: 20px;">
                                        <i class="fas fa-exclamation-circle"></i> No hay movimientos registrados
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
                    { targets: [8, 9], orderable: false } // Desactiva ordenación en "Editar" y "Eliminar"
                ],
                initComplete: function() {
                    // Aplicar formato después de que DataTables renderice la tabla
                    window.applyNumberFormatting(['cops'], []);
                }
            });

            // Manejo de la eliminación con SweetAlert2
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar este movimiento? Esta acción no se puede deshacer.',
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

    <script>
        /**
         * Script reutilizable para formatear números con separadores de miles en elementos HTML.
         * Acepta listas de 'names' e 'ids' para identificar los elementos a formatear.
         * No depende de librerías externas ni de internet.
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Función para formatear números con separadores de miles
            function formatNumberWithThousands(number) {
                // Convertir a número si es una cadena y manejar el símbolo $
                const num = typeof number === 'string' ? parseFloat(number.replace(/[^0-9.-]+/g, '')) : number;
                if (isNaN(num)) return '$0.00'; // Manejar casos inválidos

                // Convertir a string con dos decimales
                const fixedNumber = num.toFixed(2);
                // Separar la parte entera y decimal
                const [integerPart, decimalPart] = fixedNumber.split('.');
                // Agregar comas cada 3 dígitos en la parte entera
                let formattedInteger = '';
                const len = integerPart.length;
                for (let i = 0; i < len; i++) {
                    if (i > 0 && (len - i) % 3 === 0) {
                        formattedInteger += ',';
                    }
                    formattedInteger += integerPart[i];
                }
                // Combinar parte entera y decimal con el símbolo $
                return `$${formattedInteger}.${decimalPart}`;
            }

            // Función para aplicar el formato a elementos por name o id
            function applyNumberFormatting(names = [], ids = []) {
                // Procesar elementos por 'name'
                names.forEach(name => {
                    const elements = document.getElementsByName(name);
                    for (let i = 0; i < elements.length; i++) {
                        const element = elements[i];
                        const value = element.textContent || element.innerText || element.value;
                        const number = parseFloat(value.replace(/[^0-9.-]+/g, '')); // Extraer número
                        if (!isNaN(number)) {
                            element.textContent = formatNumberWithThousands(number);
                        }
                    }
                });

                // Procesar elementos por 'id'
                ids.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        const value = element.textContent || element.innerText || element.value;
                        const number = parseFloat(value.replace(/[^0-9.-]+/g, '')); // Extraer número
                        if (!isNaN(number)) {
                            element.textContent = formatNumberWithThousands(number);
                        }
                    }
                });
            }

            // Exponer la función al ámbito global
            window.applyNumberFormatting = applyNumberFormatting;
        });
    </script>
@endsection