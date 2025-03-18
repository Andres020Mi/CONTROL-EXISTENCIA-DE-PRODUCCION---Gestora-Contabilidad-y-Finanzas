@extends('layouts.app')
@section('header')
   Crear articulo
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

    .title-h1{
        font-size: 50px;
        width: 100%;
        text-align: center;
    }
</style>
<h2 class="title-h1">Crear Artículo</h2>
<form action="{{ route('articulos.store') }}" method="POST">
    @csrf
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Unidad de Medida:</label>
    <select name="unidad_medida" required>
        <option value="ml">ml</option>
        <option value="kg">kg</option>
        <option value="l">l</option>
        <option value="g">g</option>
    </select>

    <label>Cantidad Inicial:</label>
    <input type="number" name="cantidad_inicial" value="0" required>

    <button type="submit">Guardar</button>
</form>
<a href="{{ route('articulos.index') }}">Volver</a>
@endsection
