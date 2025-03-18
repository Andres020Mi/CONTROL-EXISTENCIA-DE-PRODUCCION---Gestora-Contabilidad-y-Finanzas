@extends('layouts.app')

@section('header')
    Editar Movimiento
@endsection

@section('content')
<style>
    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    button {
        width: 100%;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #218838;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 10px;
        text-decoration: none;
        color: #007bff;
    }

    a:hover {
        text-decoration: underline;
    }

    .title-h1 {
        font-size: 50px;
        width: 100%;
        text-align: center;
    }
</style>

<h2 class="title-h1">Editar Movimiento #{{ $movimiento->id }}</h2>

<form action="{{ route('movimientos.update', $movimiento) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Artículo:</label>
    <select name="articulo_id" required>
        @foreach ($articulos as $articulo)
            <option value="{{ $articulo->id }}" {{ $movimiento->articulo_id == $articulo->id ? 'selected' : '' }}>
                {{ $articulo->nombre }}
            </option>
        @endforeach
    </select>

    <label>Cantidad:</label>
    <input type="number" name="cantidad" min="1" value="{{ $movimiento->cantidad }}" required>

    <label>Tipo de Movimiento:</label>
    <select name="tipo" required>
        <option value="entrada" {{ $movimiento->tipo == 'entrada' ? 'selected' : '' }}>Entrada</option>
        <option value="salida" {{ $movimiento->tipo == 'salida' ? 'selected' : '' }}>Salida</option>
    </select>

    <label>Fecha del Movimiento:</label>
    <input type="date" name="fecha" value="{{ $movimiento->fecha->format('Y-m-d') }}" required>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('movimientos.index') }}">Volver</a>
@endsection