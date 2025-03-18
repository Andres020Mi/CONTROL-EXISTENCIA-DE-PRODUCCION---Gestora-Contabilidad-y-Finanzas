@extends('layouts.app')

@section('header')
    Movimientos
@endsection

@section('content')
<!-- Recursos externos -->
<link rel="stylesheet" href="{{ asset('DataTables/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('DataTables/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
        color: #2c3e50;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    h1 {
        font-size: 2.5rem;
        color: #34495e;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: #1abc9c;
        color: #fff;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
        transition: transform 0.2s, background 0.3s;
        box-shadow: 0 2px 8px rgba(26, 188, 156, 0.3);
    }

    .btn-create:hover {
        background: #16a085;
        transform: translateY(-2px);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    th, td {
        padding: 15px;
        text-align: left;
    }

    th {
        background: #34495e;
        color: #ecf0f1;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    td {
        border-bottom: 1px solid #ecf0f1;
        font-size: 1rem;
        color: #2c3e50;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background: #f5f7fa;
        transition: background 0.2s;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        text-decoration: none;
        font-weight: 500;
        transition: transform 0.2s, box-shadow 0.3s;
        cursor: pointer;
    }

    .btn-editar {
        background: #f1c40f;
        color: #2c3e50;
        box-shadow: 0 2px 6px rgba(241, 196, 15, 0.3);
    }

    .btn-editar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(241, 196, 15, 0.4);
    }

    .btn-eliminar {
        background: #e74c3c;
        color: #fff;
        border: none;
        box-shadow: 0 2px 6px rgba(231, 76, 60, 0.3);
    }

    .btn-eliminar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 8px;
        border: none;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 20px;
        background: #fff;
        color: #3498db;
        border: none;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #3498db;
        color: #fff;
        box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
    }
</style>

<div class="container">
    <h1>Lista de Movimientos</h1>

    <a href="{{ route('movimientos.create') }}" class="btn-create" style="margin-bottom:20px;">
        <i class="fas fa-plus" style="margin-right: 8px;"></i> Registrar Movimiento
    </a>

    <table id="miTabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Artículo</th>
                <th>Cantidad</th>
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
                    <td>{{ $movimiento->articulo->nombre ?? 'N/A' }}</td>
                    <td>{{ $movimiento->cantidad }}</td>
                    <td>{{ ucfirst($movimiento->tipo) }}</td>
                    <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                    <td>{{ $movimiento->semana->inicio ?? 'N/A' }} - {{ $movimiento->semana->fin ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('movimientos.edit', $movimiento->id) }}" class="btn btn-editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('movimientos.destroy', $movimiento->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este movimiento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-eliminar">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #7f8c8d;">
                        <i class="fas fa-exclamation-circle" style="margin-right: 5px;"></i> No hay movimientos registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Recursos externos -->
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
                { targets: [6, 7], orderable: false } // Desactiva ordenación en "Editar" y "Eliminar"
            ]
        });
    });
</script>
@endsection