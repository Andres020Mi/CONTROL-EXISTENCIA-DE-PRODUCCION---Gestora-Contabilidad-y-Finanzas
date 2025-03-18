@extends('layouts.app')

@section('header')
    Artículos
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
    .btn {
        display: inline-block;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        transition: background 0.3s, color 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-ver {
        background-color: #17a2b8; /* Azul claro */
        color: white;
    }

    .btn-ver:hover {
        background-color: #138496;
    }

    .btn-editar {
        background-color: #ffc107; /* Amarillo */
        color: black;
    }

    .btn-editar:hover {
        background-color: #e0a800;
    }

    .btn-eliminar {
        background-color: #dc3545; /* Rojo */
        color: white;
    }

    .btn-eliminar:hover {
        background-color: #c82333;
    }

    .btn-eliminar form {
        display: inline;
    }

    .title-h1{
        font-size: 50px;
    }

    .form-semana {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f4f4f4;
    padding: 12px 16px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 400px;
}

.form-semana label {
    font-weight: 600;
    color: #333;
}

.form-semana input {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 14px;
    transition: border 0.3s ease-in-out;
}

.form-semana input:focus {
    border-color: #007bff;
    outline: none;
}

.form-semana button {
    background: #007bff;
    color: white;
    font-weight: 600;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.form-semana button:hover {
    background: #0056b3;
}
}
</style>
<div class="content2">


<h1 class="title-h1">Lista de Artículos</h1>

<!-- Formulario para seleccionar la semana -->
<form method="GET" action="{{ route('articulos.index') }}" class="form-semana">
    <label for="fecha">Seleccionar Semana:</label>
    <input type="date" id="fecha" name="fecha" value="{{ $fechaSeleccionada }}">
    <button type="submit">Filtrar</button>
</form>

<a href="{{ route('articulos.create') }}">Crear Nuevo Artículo</a>

<table border="1" id="miTabla">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Unidad de Medida</th>
            <th>Cantidad Inicial</th> <!-- NUEVO -->
            <th>Entradas Semana</th>
            <th>Salidas Semana</th>
            <th>Cantidad Total Actual</th>
            <th>Fecha Actualización</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articulos as $articulo)
        <tr>
            <td>{{ $articulo->id }}</td>
            <td>{{ $articulo->nombre }}</td>
            <td>{{ $articulo->unidad_medida }}</td>
            <td>{{ $articulo->cantidad_inicial }}</td> <!-- NUEVO -->
            <td>{{ $articulo->entradas_semana }}</td>
            <td>{{ $articulo->salidas_semana }}</td>
            <td>{{ $articulo->cantidad_actual }}</td>
            <td>{{ $articulo->fecha_actualizacion }}</td>
            <td>
            
                <a href="{{ route('articulos.edit', $articulo->id) }}" class="btn btn-editar">Editar</a>
                <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-eliminar">Eliminar</button>
                </form>
            </td>
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
