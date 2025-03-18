@extends('layouts.app')

@section('header')
    Movimientos
@endsection

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

<!-- Estilos personalizados -->
<style>
    .content2{
        width: 95%;
        margin: auto;
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    a {
        display: inline-block;
        margin-bottom: 15px;
        padding: 8px 12px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s;
    }

    a:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background: #f2f2f2;
    }

    tr:hover {
        background: #ddd;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ccc;
        padding: 6px;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 6px 12px;
        margin: 2px;
        border-radius: 4px;
        border: 1px solid #007bff;
        background: #fff;
        color: #007bff;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #007bff;
        color: white;
    }
    .title-h1{
        font-size: 50px;
    }
}
</style>
<div class="content2">

    <h1 class="title-h1">Lista de Movimientos</h1>

    <a href="{{ route('movimientos.create') }}">Registrar Movimiento</a>
    
    <table id="miTabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Semana</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
            <tr>
                <td>{{ $movimiento->id }}</td>
                <td>{{ $movimiento->articulo->nombre }}</td>
                <td>{{ $movimiento->cantidad }}</td>
                <td>{{ ucfirst($movimiento->tipo) }}</td>
                <td>{{ $movimiento->fecha->format('d-m-Y') }}</td>
                <td>{{ $movimiento->semana->inicio }} / {{ $movimiento->semana->fin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    
    <!-- DataTables JS -->
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
    
</div>
@endsection
